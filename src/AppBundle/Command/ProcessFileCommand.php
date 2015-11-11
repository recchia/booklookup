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
use AppBundle\Exception\BookNotFoundException;

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
        $apiCode = $input->getArgument('apiCode');
        $source = $input->getArgument('source');
        $target = $input->getArgument('target');
        if (file_exists($source)) {
            $this->container = $this->getContainer();
            switch ($apiCode) {
                case 'google':
                    $excel = $this->container->get("phpexcel")->createPHPExcelObject($source);
                    $sheet = $excel->getActiveSheet();
                    $highestRow = $sheet->getHighestRow();
                    $phpExcel = $this->container->get("phpexcel")->createPHPExcelObject();
                    $phpExcel->getProperties()->setCreator('Linio BookLookup')
                        ->setLastModifiedBy('Linio BookLookup')
                        ->setTitle('Archivo de Libros')
                        ->setSubject('Listado de Libros')
                        ->setDescription('Archivo generado automáticamente por Linio BookLookup')
                        ->setKeywords('linio libros excel')
                        ->setCategory('Libros');
                    $phpExcel->setActiveSheetIndex(0);
                    $phpExcel->getActiveSheet()->setCellValue('A1', 'Título');
                    $phpExcel->getActiveSheet()->setCellValue('B1', 'Autor');
                    $phpExcel->getActiveSheet()->setCellValue('C1', 'Número de Páginas');
                    $phpExcel->getActiveSheet()->setCellValue('D1', 'Dimensiones');
                    $phpExcel->getActiveSheet()->setCellValue('E1', 'Categoría');
                    $phpExcel->getActiveSheet()->setCellValue('F1', 'Descripción');
                    $phpExcel->getActiveSheet()->setCellValue('G1', 'ISBN_10');
                    $phpExcel->getActiveSheet()->setCellValue('H1', 'ISBN_13');
                    $phpExcel->getActiveSheet()->setCellValue('I1', 'Imagen');
                    $vendor = $this->container->get('doctrine.orm.entity_manager')->getRepository("AppBundle:ApiVendor")->findByCode($apiCode);
                    $adapter = $this->container->get("api.adapter.factory")->startFactory($vendor);
                    $bar = new ProgressBar($output, $highestRow);
                    $bar->setFormat("<comment> %message%\n %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%</comment>");
                    $bar->setMessage('<comment>Processing file...</comment>');
                    $bar->start();
                    $i = 2;
                    for ($row = 1; $row <= $highestRow; ++$row) {
                        try {
                            $book = $adapter->findOne($sheet->getCellByColumnAndRow(0, $row)->getValue());
                            $phpExcel->getActiveSheet()->setCellValue('A' . $i, $book['title']);
                            $phpExcel->getActiveSheet()->setCellValue('B' . $i, $book['author']);
                            $phpExcel->getActiveSheet()->setCellValue('C' . $i, $book['pages']);
                            $phpExcel->getActiveSheet()->setCellValue('D' . $i, $book['dimensions']);
                            $phpExcel->getActiveSheet()->setCellValue('E' . $i, $book['category']);
                            $phpExcel->getActiveSheet()->setCellValue('F' . $i, $book['description']);
                            $phpExcel->getActiveSheet()->setCellValue('G' . $i, $book['isbn10']);
                            $phpExcel->getActiveSheet()->setCellValue('H' . $i, $book['isbn13']);
                            $phpExcel->getActiveSheet()->setCellValue('I' . $i, $book['image']);
                            $i++;
                        } catch (BookNotFoundException $e) {
                            $logger = $this->container->get("logger");
                            $logger->info($e->getMessage());
                        } catch (ApiException $e) {
                            $logger = $this->container->get("logger");
                            $logger->error($e->getMessage());
                        }
                        $bar->advance();
                    }
                    $bar->setMessage('<comment>Process Done.</comment>');
                    $bar->clear();
                    $bar->display();
                    $bar->finish();
                    $phpExcel->setActiveSheetIndex(0);
                    $writer = $this->container->get('phpexcel')->createWriter($phpExcel, 'Excel2007');
                    $writer->save($target);
                    $output->writeln("");
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