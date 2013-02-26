<?php

namespace Juicio\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
//use Juicio\Entity\Juicio;


/**
 * Edificio
 *
 * @ORM\Entity
 * @ORM\Table(name="edificio")
 */
class Edificio
{
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Attributes({"id":"edificio"})
     * @Annotation\Attributes({"class":"felement"})
     * @Annotation\Options({"label":"Edificio:","empty_option":""})
     * @Annotation\Filter({"name":"StripTags"})
     * @ORM\Column(type="string")
     * @ORM\Column(name="edificio")
     */
    public $edificio;
    
    public function getEdificio() {
        return $this->edificio;
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
