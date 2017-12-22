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
        // grab the paginator from the AlbumTable
        $paginator = $this->getAlbumTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 20
        $paginator->setItemCountPerPage(10);

        return new ViewModel(array(
            'paginator' => $paginator
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
