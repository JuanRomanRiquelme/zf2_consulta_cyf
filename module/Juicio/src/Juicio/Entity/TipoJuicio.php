<?php

namespace Juicio\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
//use Juicio\Entity\Juicio;


/**
 * TipoJuicio
 *
 * @ORM\Entity
 * @ORM\Table(name="t_juicio")
 * @property string $tipoJuicio
 * @property int $id
 */
class TipoJuicio
{
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @ORM\Column(type="string")
     * @ORM\Column(name="t_juicio")
     */
    public $tipoJuicio;
    
    public function getTipoJuicio() {
        return $this->tipoJuicio;
    }
    
    
    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }
 
    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }
    
    /**
    * Populate from an array.
    *
    * @param array $data
    */
    public function populate($data = array()) 
    {
        $this->id = $data['id'];
        $this->tipoJuicio = $data['tipoJuicio'];
    }
    
    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
        
}
