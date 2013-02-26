<?php

namespace Exped\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Exped\Entity\Exped;
use Exped\Entity\TipoActor;
use Zend\InputFilter\InputFilterInterface;

/**
 * Actor
 *
 * @ORM\Entity
 * @ORM\Table(name="actor_rol")
 * @property string $nombre
 * @property int $id
 */
class Actor
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
     * @ORM\Column(name="actor_nombre")
     */
    public $nombre;
    
     /**
     * @ORM\Column(type="string")
     * @ORM\Column(name="afecta")
     */
    public $afecta;
    
    /**
     * @ORM\ManyToOne(targetEntity="Exped", inversedBy="actores")
     * @ORM\JoinColumn(name="exped_id", referencedColumnName="id")
     */
    public $exped;
    
    /**
     * @ORM\OneToOne(targetEntity="TipoActor")
     * @ORM\JoinColumn(name="t_actor_ID", referencedColumnName="id")
     */
    public $tipoActor;
    
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
    
    public function setExped(Exped $exped = null) {
        $this->exped = $exped;
    }
    
    public function getExped() {
        return $this->exped;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function setTipoActor(TipoActor $tActor = null) {
        $this->tipoActor = $tActor;
    }
    
    public function getTipoActor() {
        return $this->tipoActor;
    }
    
    public function isStActor($st_actor){
        return (bool)($this->getTipoActor()->getSubTipoActor() == $st_actor);
    }
    
    public function __construct(){
        $this->exped = new Exped();
        $this->tipoActor = new TipoActor();
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
        $this->nombre = $data['nombre'];
        //$this->exped = $data['exped'];
    }
 
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
        
}
