<?php

namespace Application\Model;

use Application\Model\Rowset\Inventory;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\TableGateway;
use RuntimeException;

class InventoryTable{

    private $tableGateway;

    public function __construct($table, AdapterInterface $adapter, $features = null, ResultSet $resultSetPrototype = null, Sql $sql = null)
    {
        $this->tableGateway = new TableGateway($table, $adapter, $features, $resultSetPrototype, $sql);
    }

    public function getById($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception('inventory not found with id: '.$id);
        }
        return $row;
    }

    public function getAll()
    {
        $results = $this->tableGateway->select();
        return $results;
    }

    public function save(Inventory $model)
    {
        $data = [
            'title' => $model->getTitle(),
            'description' => $model->getDescription(),
            'qty' => $model->getQty(),
            'image' => $model->getImage(),
        ];
        return $this->saveRow($model, $data);
    }

    // secondary method
    private function saveRow(Inventory $model, $data=null){
        $id = $model->getId();

        if(empty($data)){
            $data = $model->getArrayCopy();
        }
        
        if(empty($id)){
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        }
        
        if(!$this->getById($id)){
            throw new RuntimeException(get_class($model).' with id: '.$id.' not found');
        }
        
        $this->tableGateway->update($data, ['id' => $id]);
        return $id;
    }
}
?>