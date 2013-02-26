<?php

namespace Exped;

use Exped\Model\Exped;
use Exped\Model\ExpedTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Exped\Model\ExpedTable' =>  function($sm) {
                    $tableGateway = $sm->get('ExpedTableGateway');
                    $table = new ExpedTable($tableGateway);
                    return $table;
                },
                'ExpedTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Exped());
                    return new TableGateway('exped', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
    
}
