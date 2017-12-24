<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\Album;
use Zend\Config\Reader;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\Client;
use Zend\View\Model\JsonModel;

class AlbumController extends AbstractActionController
{
    protected $albumTable;
    protected $result = [];
    protected $num = [];

    public function indexAction()
    {
        // grab the paginator from the AlbumTable
        /*$paginator = $this->getAlbumTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        // set the number of items per page to 20
        $paginator->setItemCountPerPage(20);

        return new ViewModel(array(
            'paginator' => $paginator
        ));*/
        /*$result = new ViewModel(array(
            'success'=>true,
            'results' => $this->getAlbumTable()->fetchAll(),
        ));*/
        $results = $this->getAlbumTable()->fetchAll();
        $data = array();
        foreach ($results as $result) {
            $data[] = $result;
        }

        return new JsonModel(array(
                'data' => $data,
                'success' => true,
            )
        );
    }

    public function addAction()
    {
        $reader = new Reader\Xml();
        $newData = $reader->fromFile('instock.xml');

        $album = new Album();
        foreach ($newData['PRODUCTS']['PRODUCT'] as $val) {
            $album->exchangeArray($val);
            $this->getAlbumTable()->saveAlbum($album);
        }
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }

    public function updateProductTableAction()
    {
        $request = $this->getRequest();

        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        /*$reader = new Reader\Xml();
        $newData = $reader->fromFile('instock.xml');*/

        $client = new Client('https://mw-glasberg.com/media/feed/instock.xml', array(
            'maxredirects' => 0,
            'timeout' => 30
        ));

        $response = $client->send();
        $data = simplexml_load_string($response->getBody());

        $products = $this->xmlToArray($data);

        foreach ($products['PRODUCTS']['PRODUCT'] as $j => $products) {
            foreach ($products as $k => $product) {
                $this->result[$j][$k] = (string)$product;
            }
        }

        $album = new Album();
        foreach ($this->result as $val) {
            $album->exchangeArray($val);
            $this->getAlbumTable()->saveAlbum($album);
        }
    }

    public function xmlToArray($xmlObject, $out = [])
    {
        foreach ((array)$xmlObject as $index => $node)
            $out[$index] = (is_object($node)) ? $this->xmlToArray($node) : $node;

        return $out;
    }
}
