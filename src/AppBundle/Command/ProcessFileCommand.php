<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 09/11/15
 * Time: 03:09 PM
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class ProcessFileCommand extends ContainerAwareCommand
{
    protected $container = null;

    protected function configure()
    {
        $this
            ->setName('books:process')
            ->setDescription('Process Excel file with isbn to get books info.')
            ->addArgument('apiCode', InputArgument::REQUIRED, 'Api code where search for books')
            ->addArgument('source', InputArgument::REQUIRED, 'Source file with isbn codes')
            ->addArgument('target', InputArgument::REQUIRED, 'Target file where store data requested')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $apiName = $input->getArgument('apiCode');
        $source = $input->getArgument('source');
        $target = $input->getArgument('target');
        if (file_exists($source)) {
            $this->container = $this->getApplication()->getKernel()->getContainer();
            switch ($apiName) {
                case 'google':
                    $excel = $this->container->get("phpexcel")->createPHPExcelObject($source);
                    $sheet = $excel->getActiveSheet();
                    $highestRow = $sheet->getHighestRow();
                    $isbnArray = [];
                    $bar = new ProgressBar($output, $highestRow);
                    $bar->setFormat("<comment> %message%\n %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%</comment>");
                    $bar->setMessage('<comment>Reading ISBN from source file...</comment>');
                    $bar->start();
                    for ($row = 1; $row <= $highestRow; ++$row) {
                        $isbnArray[] = $sheet->getCellByColumnAndRow(0, $row)->getValue();
                        $bar->advance();
                    }
                    $bar->setMessage('<comment>ISBN source loaded</comment>');
                    $bar->clear();
                    $bar->display();
                    $bar->finish();
                    $output->writeln('');
                    $phpExcel = $this->container->get("phpexcel")->createPHPExcelObject();
                    $phpExcel->getProperties()->setCreator('Piero Recchia')
                        ->setLastModifiedBy('Piero Recchia')
                        ->setTitle('Office 2007 XLSX Test Document')
                        ->setSubject('Office 2007 XLSX Test Document')
                        ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
                        ->setKeywords('office 2007 openxml php')
                        ->setCategory('Test result file');
                    $phpExcel->setActiveSheetIndex(0);
                    $phpExcel->getActiveSheet()->setCellValue('A1', 'Titulo');
                    $phpExcel->getActiveSheet()->setCellValue('B1', 'Autor');
                    $phpExcel->getActiveSheet()->setCellValue('C1', 'Editorial');
                    $phpExcel->getActiveSheet()->setCellValue('D1', 'Descripcion');
                    $phpExcel->getActiveSheet()->setCellValue('E1', 'Numero de Paginas');
                    $phpExcel->getActiveSheet()->setCellValue('F1', 'Imagen');
                    $progress = new ProgressBar($output, count($isbnArray));
                    $progress->setFormat("<comment> %message%\n %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%</comment>");
                    $progress->setMessage('<comment>Searching Books in ' . $apiName . '...</comment>');
                    $api = new GoogleBooksApiAdapter(['api_key' => 'AIzaSyDfR5cB9PNeD-fn6FtEs12n5CsbFXQQgDU']);
                    $i = 2;
                    $progress->start();
                    foreach ($isbnArray as $isbn) {
                        try {
                            $book = $api->findOne($isbn);
                            $phpExcel->getActiveSheet()->setCellValue('A' . $i, $book['title']);
                            $phpExcel->getActiveSheet()->setCellValue('B' . $i, $book['authors']);
                            $phpExcel->getActiveSheet()->setCellValue('C' . $i, $book['publisher']);
                            $phpExcel->getActiveSheet()->setCellValue('D' . $i, $book['description']);
                            $phpExcel->getActiveSheet()->setCellValue('E' . $i, $book['pageCount']);
                            $phpExcel->getActiveSheet()->setCellValue('F' . $i, $book['imageLink']);
                            $i++;
                        } catch (BookNotFoundException $e) {
                            //Add log
                        } catch (ApiException $e) {
                            //Add Log
                        }
                        $progress->advance();
                    }
                    $progress->setMessage('<comment>Search ready</comment>');
                    $progress->clear();
                    $progress->display();
                    $progress->finish();
                    $output->writeln('');
                    $output->writeln("<info>Saving data in $target</info>");
                    $phpExcel->setActiveSheetIndex(0);
                    $writer = $this->get('phpexcel')->createWriter($phpExcel, 'Excel2007');
                    $writer->save($target);
                    $output->writeln("<info>Data saved in $target</info>");
                    break;
                default:
                    $output->writeln('<error>Unrecognized API</error>');
                    break;
            }
        } else {
            $output->writeln('<error>The target file ' . $source . ' does not exist</error>');
        }

    }
}