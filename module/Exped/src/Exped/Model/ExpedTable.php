<?php

namespace Exped\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

// Idealmente, esto va en una clase (tablegateway?) personalizada
use Zend\Db\Sql\Where;

class ExpedTable implements ServiceLocatorAwareInterface
{
    protected $tableGateway;
    protected $serviceLocator;

    public function __construct(TableGateway $tableGateway)
    {
        //$this->serviceLocator->get('Zend\Log')->info('constructExpedTable');
        $this->tableGateway = $tableGateway;
    }
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }
    
    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getExped($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    private function decodeAnio($code){
        
        return 2002 + $code;
        
    }
    
    public function searchExped($data)
    {
        // El Logger esta en global.php Es LA joda de ZF2, el servicelocator
        // $this->serviceLocator->get('Zend\Log')->info('searchExped');
        foreach ($data as $k=>$v){
            if (!$v)
                unset($data[$k]);
        }
        unset($data['submit']);
        
        // Es un combo "inventado" (medio cabeza)
        // Esto es bullshit, hay que usar Hydrators!!
        if ($data['anio'])
            $data['anio'] = $this->decodeAnio($data['anio']);
            
        $where = new Where();
        // TODAS los criterios de busqueda con "like"... mmmm...
        foreach ($data->toArray() as $k=>$v){
            //$where->equalTo($k,$v);
            $where->like($k,$v."%");
        }
        
        //$this->serviceLocator->get('Zend\Log')->info(var_export($data->toArray(),true));
        //$rowset = $this->tableGateway->select($data->toArray());
        $rowset = $this->tableGateway->select($where);
                
        return $rowset;
        
    }
    
}