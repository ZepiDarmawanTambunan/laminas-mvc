<?php

declare(strict_types=1);

namespace Application;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Application\Model\Rowset\User;
use Application\Model\UsersTable;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function getServiceConfig()
    {   
	    return array(
            'factories' => array(
                'UsersTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Laminas\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    // $config = $sm->get('Config');
                    // $baseUrl = $config['view_manager']['base_url'];
                    // $resultSetPrototype->setArrayObjectPrototype(new User($baseUrl));
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\UsersTable' => function($sm) {
                    $tableGateway = $sm->get('UsersTableGateway');
                    $table = new UsersTable($tableGateway);
                    return $table;
                },
            )
        );
    }
}
