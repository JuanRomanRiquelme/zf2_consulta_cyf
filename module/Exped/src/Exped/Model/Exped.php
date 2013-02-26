<?php
/*
 *
 * DEPRECADO
 * ESTOY USANDO LA ENTITY DE DOCTRINE 2
 *
*/
namespace Exped\Model;

use Zend\Form\Annotation;

/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("Exped")
 */
class Exped
{
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required(false)
     * @Annotation\Attributes({"type":"hidden"})
     */
    public $id;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Exped. Numero:"})
     */
    public $num;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Required(false)
     * @Annotation\Options({"label":"Exped. Anio:","empty_option":"",
     * "value_options":{"1":"2003","2":"2004","3":"2005","4":"2006","5":"2007","6":"2007","7":"2009","8":"2010","9":"2011","10":"2012"}})
     */
    public $anio;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Attributes({"type":"hidden"})
     */
    public $codigo;
    
     /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Numero Exped. UACF:"})
     */
    public $num_exp_adm;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Attributes({"type":"hidden"})
     */
    public $juzgado;
    

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Consultar"})
     */
    public $submit;
    
    /*
    * Hay que implementar este método para que conecte con el TableGateway 
    */
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->num     = (isset($data['num'])) ? $data['num'] : null;
        $this->anio     = (isset($data['anio'])) ? $data['anio'] : null;
        $this->codigo     = (isset($data['codigo'])) ? $data['codigo'] : null;
        $this->num_exp_adm     = (isset($data['num_exp_adm'])) ? $data['num_exp_adm'] : null;
        $this->juzgado     = (isset($data['juzgado'])) ? $data['juzgado'] : null;
    }
}
