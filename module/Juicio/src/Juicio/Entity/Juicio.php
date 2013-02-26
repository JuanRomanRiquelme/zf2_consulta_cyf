<?php

namespace Juicio\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Exped\Entity\Exped;

use Exped\Entity\TipoCausa;

use Juicio\Entity\TipoJuicio;
use Juicio\Entity\JuicioLocacion;
use Zend\InputFilter\InputFilterInterface;

//use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Juicio
 *
 * @ORM\Entity
 * @ORM\Table(name="juicio")
 * @property int $id
 * @property string $fecha
 */
class Juicio
{
    
    /**
     * @Annotation\Attributes({"type":"hidden"})
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    
    /**
     * @Annotation\Attributes({"type":"hidden"})
     * @ORM\OneToOne(targetEntity="Exped\Entity\Exped")
     * @ORM\JoinColumn(name="exped_id", referencedColumnName="id")
     */
    public $exped;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\Attributes({"id":"fecha"})
     * @Annotation\Attributes({"class":"felement"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Fecha:"})
     * @ORM\Column(type="date")
     */
    public $fecha;
    
    /**
     * @Annotation\Attributes({"type":"hidden"})
     * @ORM\Column(type="time")
     */
    public $hora_desde;
    
    /**
     * @Annotation\Attributes({"type":"hidden"})
     * @ORM\Column(type="time")
     */
    public $hora_hasta;
    
    /**
     * @Annotation\Attributes({"type":"hidden"})
     * @ORM\OneToOne(targetEntity="TipoJuicio")
     * @ORM\JoinColumn(name="t_juicio_ID", referencedColumnName="id")
     */
    public $tipoJuicio;
    
    /**
     * @Annotation\Attributes({"type":"hidden"})
     * @ORM\OneToOne(targetEntity="JuicioLocacion")
     * @ORM\JoinColumn(name="juicio_locacion_ID", referencedColumnName="id")
     */
    public $locacion;
    
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
    
    public function setTipoJuicio(TipoJuicio $tJuicio = null) {
        $this->tipoJuicio = $tJuicio;
    }
    
    public function getTipoJuicio() {
        return $this->tipoJuicio->getTipoJuicio();
    }
    
    public function setLocacion(JuicioLocacion $tJuicio = null) {
        $this->locacion = $tJuicio;
    }
    
    public function getLocacion() {
        return $this->locacion->getLocacion();
    }
    
    public function setExped(Exped $exped = null) {
        $this->exped = $exped;
    }
    
    public function getExped() {
        return $this->exped;
    }
    
    public function __construct(){
        $this->exped = new Exped();
        $this->tipoJuicio = new TipoJuicio();
        $this->locacion = new JuicioLocacion();
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
