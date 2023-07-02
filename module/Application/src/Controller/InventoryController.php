<?php

namespace Application\Controller;

use Application\Model\InventoryTable;
use Application\Model\Rowset\Inventory;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Validator\File\UploadFile;
use Laminas\Filter\File\RenameUpload;

class InventoryController extends AbstractActionController
{
    private $inventoryTable = null;

    public function __construct(InventoryTable $inventoryTable)
    {
        $this->inventoryTable = $inventoryTable;    
    }

    public function indexAction()
    {
        $view = new ViewModel();
        $rows = $this->inventoryTable->getAll();
        $view->setVariable('inventoryRows', $rows);
        return $view;    
    }

    public function addAction(){
        $view = new ViewModel();
        $request = $this->getRequest();
        if(!$request->isPost()){  // jika [GET | localhost:8080/users/add] tampilkan view
            return $view;
        }
        // jika [POST | localhost:8080/users/add] tampilkan view
        $model = new Inventory();
        $model->exchangeArray($request->getPost()->toArray());
        
        // upload image
        $image = $request->getFiles()->toArray()['image'];
        if ($image['name'] != '') {
            $uploadValidator = new UploadFile();
            if (!$uploadValidator->isValid($image)) {
                $uploadErrors = $uploadValidator->getMessages();
                return ['errors' => $uploadErrors];
            } else {
                $newFileName = uniqid() . '_' . $image['name'];
                $newFilePath = 'public/uploads/' . $newFileName;
                move_uploaded_file($image['tmp_name'], $newFilePath);
                $model->setImage($newFileName);
            }
        }

        $inputFilter = $model->getInputFilter();
        $model->setInputFilter($inputFilter);
        $inputFilter->setData($model->getArrayCopy());
        // dd($inputFilter->getValues());
        if (!$inputFilter->isValid()) {
            $errors = [];
            foreach ($inputFilter->getInvalidInput() as $input) {
                $errors[$input->getName()] = $input->getMessages();
            }
            return ['input' => $inputFilter, 'errors' => $errors];
        }
        $model->exchangeArray($inputFilter->getValues());
        $this->inventoryTable->save($model);
        return $this->redirect()->toRoute('inventory');
    }

    // ini contoh latihan
    public function testing(){
        // Membuat objek Inventory
        $rowset = new \Application\Model\Rowset\Inventory();

        // Mengatur input filter
        $inputFilter = $rowset->getInputFilter();
        $rowset->setInputFilter($inputFilter);
        
        // Mengisi data pada input filter
        $inputFilter->setData($rowset->getArrayCopy());

        // Memeriksa validitas input filter
        if ($inputFilter->isValid()) {
            $filteredData = $inputFilter->getValues();

            // Contoh: Menyimpan data ke database
            // $database->save($filteredData);
        } else {
            $errors = $inputFilter->getMessages();
            var_dump($errors); // array error
        }

        $view = new ViewModel(['rowset' => $rowset]);
        $view->setTemplate('application/inventory/index'); //dihapus pun masih bisa krn dia auto berdasarkan nama folder
        return $view;
    }
}