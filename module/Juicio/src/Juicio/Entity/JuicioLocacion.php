<?php

namespace Juicio\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;
use Juicio\Entity\Edificio;


/**
 * JuicioLocacion
 *
 * @ORM\Entity
 * @ORM\Table(name="juicio_locacion")
 */
class JuicioLocacion
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
     * @ORM\Column(name="juicio_locacion")
     */
    public $locacion;
    
    /**
     * @Annotation\Attributes({"type":"hidden"})
     * @ORM\OneToOne(targetEntity="Edificio")
     * @ORM\JoinColumn(name="edificio_ID", referencedColumnName="id")
     */
    public $edificio;
    
    public function getLocacion() {
        return $this->locacion;
    }
    
    public function setLocacion(Edificio $edif = null) {
        $this->edificio = $edif;
    }
    
    public function getEdificio() {
        return $this->edificio->getEdificio();
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
