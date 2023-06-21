<?php
namespace Application\Model;

use Application\Model\Rowset\User;
use Laminas\Db\TableGateway\TableGateway;
use Application\Model\Rowset\AbstractModel;
use RuntimeException;

class UsersTable{

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getById($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception('user not foound with id: '.$id);
        }
        return $row;
    }
    public function getAll()
    {
        $results = $this->tableGateway->select();
        return $results;
    }
    public function save(User $userModel)
    {
        $data = [
            'username' => $userModel->getUsername()
        ];
        return $this->saveRow($userModel, $data);
    }
    public function delete($id)
    {
        $this->deleteRow($id);
    }

    private function saveRow(User $userModel, $data=null){
        $id = $userModel->getId();

        if(empty($data)){
            $data = $userModel->getArrayCopy();
        }
        
        if(empty($id)){
            $this->tableGateway->insert($data);
            return $this->tableGateway->getLastInsertValue();
        }
        
        if(!$this->getById($id)){
            throw new RuntimeException(get_class($userModel).' with id: '.$id.' not found');
        }
        
        $this->tableGateway->update($data, ['id' => $id]);
        return $id;
    }

    private function deleteRow($id){
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}