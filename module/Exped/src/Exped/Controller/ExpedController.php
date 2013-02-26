<?php

namespace Exped\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Doctrine\ORM\EntityManager;
use Exped\Entity\Exped;
use Exped\Entity\TipoActor;
use Exped\Entity\Actor;


class ExpedController extends AbstractActionController {
    
    protected $expedTable;
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
 
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    
    public function indexAction(){
        return $this->redirect()->toRoute('exped', array(
                'action' => 'grid'
            ));
    }
    
    /*
     * Dummy Action para llamar grid.phtml
     *
     */
    public function gridAction(){
    }
    
    /*
     * No hay search-grid.phtml porque esta action devuelve json
     */
    public function searchGridAction(){
        
        $request = $this->getRequest();
        
        $em = $this->getEntityManager();
        
        $json = new JsonModel();
        
        // La llamada del JQGrid viene por GET
        if ($request->isGet()) {
            
            $query = $request->getQuery()->toArray();
            
            $wh = '1=1';
            
            foreach( $query as $k=>$v) {
                    switch ($k) {
                            case 'anio':
                                     $wh .= " AND e.".$k." = '".$v."'";   
                            case 'id':
                            case 'num':
                            case 'num_exp_adm':
                                    $wh .= " AND e.".$k." LIKE '".$v."%'";
                            case 'codigo':
                                    $wh .= " AND e.".$k." LIKE '%".$v."%'";
                                    break;
                    }
            }
            
            $query = $em->createQuery("SELECT COUNT(e.id) FROM Exped\Entity\Exped e WHERE ".$wh);
            $cant_records = $query->getSingleScalarResult();
            
            $row_limit = $request->getQuery()->rows;
            $page = $request->getQuery()->page;
            $sidx = $request->getQuery()->sidx;
            $sord = $request->getQuery()->sord;
            
            //$this->getServiceLocator()->get('Zend\Log')->info(var_export($request->getQuery()->anio,true));
            
            if ($cant_records > 0)
                $cant_paginas = ceil($cant_records/$row_limit);
            else
                $cant_paginas = 0;
                
            // Para hacer solo la consulta de los registros que voy a mostrar
            if ($page > $cant_paginas) $page = $cant_paginas;
                    $start = $row_limit*$page - $row_limit;
            if ($start<0) $start = 0;
            
            $res['total'] = $cant_paginas;
            $res['page'] = $page;
            $res['records'] = $cant_records;
            
            // Los params del where tambien pueden ir en un array, pero es al pedo.
            $query = $em->createQuery("SELECT e FROM Exped\Entity\Exped e WHERE ".$wh." ORDER BY e.".$sidx." ".$sord);
            $query->setFirstResult($start);
            $query->setMaxResults($row_limit);
            $expeds = $query->getResult();
            
            foreach ($expeds as $k=>$exped){
                
                $res['rows'][$k]['id'] = $k;
                $res['rows'][$k]['cell'] = array($exped->id,
                                                 $exped->num,
                                                 $exped->anio,
                                                 $exped->codigo,
                                                 $exped->num_exp_adm,
                                                 $exped->getActorStringByStActor('juez'),
                                                 $exped->getActorStringByStActor('fiscal'),
                                                 $exped->getActorStringByStActor('defensor'),
                                                );
                
                //$this->getServiceLocator()->get('Zend\Log')->info(var_export($exped->getJuzgados()->__toString(),true));
                
            }
            
            $json = new JsonModel($res);
                
        }
        
        return $json;
        
    }
    
    /*
     * Queda como muestra de busqueda de request NO-AJAX
     * En conjunto con el search.phtml
     */
    public function searchAction(){
    
        $exped = new Exped();
        $builder = new AnnotationBuilder();
        $form = $builder->createForm($exped);
        $ret['form'] = $form;
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $form->setData($request->getPost());
            if ($form->isValid()){
                // Saco los vacios y el "submit" del array, asi lo uso directamente en la busqueda
                // seguro... SEGURO que hay una mejor forma de hacer esto.
                $post = array_filter($request->getPost()->toArray());
                unset ($post['submit']);
                
                $em = $this->getEntityManager();                
                $expeds = $em->getRepository('Exped\Entity\Exped')->findBy($post);
                $ret['expeds'] = $expeds;
                
                $result->setVariables((array_merge(array('success'=>true),$expeds)));
                
            }
        }
        
        return $ret;
    }
    
}