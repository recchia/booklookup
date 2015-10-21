<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 21/10/15
 * Time: 04:41 PM
 */

namespace AppBundle\Adapter\Api\Google\Book;

use AppBundle\Adapter\AdapterInterface;
use AppBundle\Exception\BookNotFoundException;
use \Google_Client;
use \Google_Service_Books;
use \Google_Service_Books_VolumeVolumeInfo;
use \Google_Service_Books_VolumeVolumeInfoImageLinks;


class Adapter implements AdapterInterface
{
    /**
     * @var Google_Service_Books
     */
    protected $api;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $client = new Google_Client();
        $client->setApplicationName('books-lookup');
        $client->setDeveloperKey($config['key']);
        $this->api = new Google_Service_Books($client);
    }

    /**
     * @param string $isbn
     *
     * @return array
     *
     * @throws BookNotFoundException
     */
    public function findOne($isbn)
    {
        $query = 'isbn:' . $isbn;
        $data = [];
        $result = $this->api->volumes->listVolumes($query, ['langRestrict' => 'es']);
        if($result->getTotalItems() == 0) {
            throw new BookNotFoundException(printf("ISBN %s NOT FOUND", $isbn));
        } else {
            foreach ($result->getItems() as $item) {
                $data[] = $this->getBookData($item->getVolumeInfo());
            }
        }

        return $data;
    }

    /**
     * @param array $isbn
     *
     * @return array
     */
    public function find(array $isbn)
    {
        // TODO: Implement find() method.
    }

    protected function getBookData(Google_Service_Books_VolumeVolumeInfo $volume)
    {
        return [
            'title' => $volume->getTitle(),
            'author' => $this->getAuthors($volume->getAuthors()),
            'pages' => $volume->getPageCount(),
            'dimensions' => $volume->getDimensions(),
            'category' => $volume->getMainCategory(),
            'description' => $volume->getDescription(),
            'isbn10' => $this->getIsbn($volume->getIndustryIdentifiers()),
            'isbn13' => $this->getIsbn($volume->getIndustryIdentifiers(), 13),
            'image' => $this->getImage($volume->getImageLinks())
        ];
    }

    /**
     * Get authors
     *
     * @param array|string $authors
     * @return string
     */
    protected function getAuthors($authors)
    {
        if (is_array($authors)) {
            return implode(', ', $authors);
        } else {
            return $authors;
        }
    }

    /**
     * Get ISBN 10 or 13
     *
     * @param array $isbn
     * @param int $type
     * @return string
     */
    protected function getIsbn(array $isbn, $type = 10)
    {
        switch($type) {
            case 10:
                return $isbn[0]['identifier'];
            break;
            case 13:
                return $isbn[1]['identifier'];
            break;
            default:
                return '';
            break;
        }
    }

    /**
     * Get the bigger image
     *
     * @param Google_Service_Books_VolumeVolumeInfoImageLinks $link
     * @return string
     */
    protected function getImage(Google_Service_Books_VolumeVolumeInfoImageLinks $link)
    {
        if(!empty($link->getLarge())) {
            return $link->getLarge();
        }
        if(!empty($link->getMedium())) {
            return $link->getMedium();
        }
        if(!empty($link->getSmall())) {
            return $link->getSmall();
        }
        if(!empty($link->getThumbnail())) {
            return $link->getThumbnail();
        }
    }
}