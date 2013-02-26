<?php

namespace Juicio\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\JsonModel;

use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;

use Doctrine\ORM\EntityManager;
use Juicio\Entity\Juicio;
use Exped\Entity\TipoCausaGrupo;

use Zend\Form\Element;

class JuicioController extends AbstractActionController {
    
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
        return $this->redirect()->toRoute('juicio', array(
                'action' => 'calendar'
            ));
    }
    
    public function calendarAction(){
        
        $juicio = new Juicio();
        
        $em = $this->getEntityManager();                
        $tcausas = $em->getRepository('Exped\Entity\TipoCausaGrupo')->findAll();
        $edifs = $em->getRepository('Juicio\Entity\Edificio')->findAll();
        
        // Para los elementos del select, hay que extraer el string de t_causa
        foreach ($tcausas as $k=>$v)
            $str_tcausas[$v->__get('id')] = $v->__get('tCausaGrupo');
        
        foreach ($edifs as $k=>$v)
            $str_edifs[$v->__get('id')] = $v->__get('edificio');
        
        
        /*
         * Ejemplo de encadenamiento de formularios
         * y agregado de elementos al form al vuelo
         */
        $builder = new AnnotationBuilder();
        $form = $builder->createForm($juicio);

        $tCausaGrupo = new TipoCausaGrupo();
        $edificio = new \Juicio\Entity\Edificio();

        $formAux = $builder->createForm($tCausaGrupo);
        // Busco el elemento de formulario "tCausaGrupo", definido con una Annotation
        $element = $formAux->get('tCausaGrupo');
        $element->setAttribute('options', $str_tcausas);
        
        $formAux2 = $builder->createForm($edificio);
        $element2 = $formAux2->get('edificio');
        $element2->setAttribute('options', $str_edifs);
        
        $submit = new Element\Submit('submit');
        $submit->setValue('Buscar');
        
        // Agrego elementos al formulario de busqueda
        $form->setAttribute('class','cform');
        $form->add($element);
        $form->add($element2);
        $form->add($submit);
        
        $request = $this->getRequest();
        if ($request->isPost()){
            $post = $request->getPost()->toArray();
            //Para que se mantengan los valores buscados
            $form->populateValues($post);
            //$this->getServiceLocator()->get('Zend\Log')->info(var_export($post,true));
        }
        
        $ret['form'] = $form;
        
        return $ret;
    }
    
    public function calendarEventsAction(){
        
        $request = $this->getRequest();
        $em = $this->getEntityManager();
        
        $start = date("Y-m-d H:i:s",$request->getPost()->start);
        $end = date("Y-m-d H:i:s",$request->getPost()->end);
        
        $res[0] = array('title'=>'bla','start'=>'2013-02-15');
        
        $query = $request->getPost()->toArray();
        
        //$this->getServiceLocator()->get('Zend\Log')->info(var_export($query,true));
        
        $wh = "j.fecha BETWEEN '".$start."' AND '".$end."' ";
        
        foreach( $query as $k=>$v) {
            switch ($k) {
                // TODO:
                // La busqueda por FECHA ni siquiere deberia venir al server,
                // debería ser un reload del calendario en la misma pagina, con el gotodate.
                case 'edificio':
                    if ($v)
                        $wh .= " AND edif.id = '".$v."'";
                        break;
                case 'tCausaGrupo':
                    if ($v)
                        $wh .= " AND tcg.id = '".$v."'";
                        break;
                case 'fecha':
                        break;
            }
        }
        
        $query = $em->createQuery("SELECT j FROM Juicio\Entity\Juicio j
                                  JOIN j.exped e
                                  JOIN e.tCausa tc
                                  JOIN tc.tCausaGrupo tcg
                                  JOIN j.locacion jl
                                  JOIN jl.edificio edif
                                  WHERE ".$wh);
        
        //$this->getServiceLocator()->get('Zend\Log')->info(var_export($query->getSQL(),true));
        $juicios = $query->getResult();
        
        foreach ($juicios as $k=>$juicio){
            
            $hd = $juicio->__get('hora_desde')->format('H:i:s');
            //$hd = $hd->format('H:i:s');
            $ha = $juicio->__get('hora_hasta');
            $ha = $ha->format('H:i:s');
            $fecha = $juicio->__get('fecha');
            $fecha = $fecha->format('Y-m-d');
            
            $start = $fecha." ".$hd;
            $end = $fecha." ".$ha;
            
            if ($num = $juicio->getExped()->__get('num'))
                $causa = " - Causa Nro. ".$num."/".$juicio->getExped()->__get('anio');
            else $causa = "";
            
            $res[$k] = array('id' => $k,
                            'title' => " ".$juicio->getTipoJuicio()." [".$juicio->getLocacion()."]".$causa,
                            'start' => $start,
                            'end'   => $end,
                            'allDay'=> false,
                            'backgroundColor' => '#36c' //es el color default
                            );
           
        }
            
        //$this->getServiceLocator()->get('Zend\Log')->info(var_export($res,true));
        
        $json = new JsonModel($res);
        
        return $json;
        
    }
    
}