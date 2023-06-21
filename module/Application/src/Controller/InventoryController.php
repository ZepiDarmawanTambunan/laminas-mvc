<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;

class InventoryController extends AbstractActionController
{
    public function indexAction(){
        $rowset = new \Application\Model\Rowset\Inventory();
        $rowset->setId(1);
        $rowset->setTitle('mie goreng');
        $rowset->setDescription('enak bgt dan murah');
        $rowset->setQty(20);
        dd($rowset);
    }

    public function showAction()
    {
        $inventoryId = $this->params()->fromRoute('id');
        $data = new JsonModel(['result' => 'inventory dengan data '.$inventoryId]);
        dd($data);
    }
}