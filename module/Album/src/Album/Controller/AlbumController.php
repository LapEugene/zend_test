<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\Album;
use Zend\Config\Reader;
use Zend\Console\Request as ConsoleRequest;

class AlbumController extends AbstractActionController
{
    protected $albumTable;

    public function indexAction()
    {
        return new ViewModel(array(
            'products' => $this->getAlbumTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $reader = new Reader\Xml();
        $newData = $reader->fromFile('instock.xml');

        $album = new Album();
        foreach ($newData['PRODUCTS']['PRODUCT'] as $val){
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
        if (!$request instanceof ConsoleRequest){
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $reader = new Reader\Xml();
        $newData = $reader->fromFile('instock.xml');

        $album = new Album();
        foreach ($newData['PRODUCTS']['PRODUCT'] as $val){
            $album->exchangeArray($val);
            $this->getAlbumTable()->saveAlbum($album);
        }
    }
}
