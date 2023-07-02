<?php
namespace Application\Model;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\TableGateway;

class ResepTable
{
    private $tableGateway;

    public function __construct($table, AdapterInterface $adapter, $features = null, ResultSet $resultSetPrototype = null, Sql $sql = null)
    {
        $this->tableGateway = new TableGateway($table, $adapter, $features, $resultSetPrototype, $sql);
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
}