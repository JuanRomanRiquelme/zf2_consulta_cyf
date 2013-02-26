<?php

namespace Exped\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;

/**
 * TipoActor
 *
 * @ORM\Entity
 * @ORM\Table(name="t_actor")
 * @property string $tipoActor
 * @property int $id
 */
class TipoActor
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
     * @ORM\Column(name="t_actor")
     */
    public $tipoActor;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @ORM\Column(type="string")
     * @ORM\Column(name="st_actor")
     */
    public $subTipoActor;
    
    
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
    
    public function getTipoActor() {
        return $this->tipoActor;
    }
    
    public function getSubTipoActor() {
        return $this->subTipoActor;
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
    
    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) 
    {
        $this->id = $data['id'];
        $this->tipoActor = $data['tipoActor'];
    }
 
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
        
}
