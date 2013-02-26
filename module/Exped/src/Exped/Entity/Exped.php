<?php

namespace Exped\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Exped\Entity\Actor;
use Exped\Entity\TipoCausa;
use Zend\InputFilter\InputFilterInterface;

/**
 * Exped
 *
 * @ORM\Entity
 * @ORM\Table(name="exped")
 * @property string $num
 * @property string $anio
 * @property string $codigo
 * @property string $num_exp_adm
 * @property int $id
 */
class Exped
{
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required(false)
     * @Annotation\Attributes({"type":"hidden"})
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    
    /**
     * @ORM\Column(type="integer")
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Exped. Numero:"})
     */
    public $num;
    
    /**
     * @ORM\Column(type="string")
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Required(false)
     */
    public $anio;
    
    /**
     * @ORM\Column(type="string");
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Attributes({"type":"hidden"})
     */
    public $codigo;
    
     /**
     * @ORM\Column(type="string");
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Numero Exped. UACF:"})
     */
    public $num_exp_adm;
    
    /**
     * @ORM\OneToOne(targetEntity="Exped\Entity\TipoCausa")
     * @ORM\JoinColumn(name="t_causa_id", referencedColumnName="id")
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Required(false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Tipo Causa:"})
     */
    public $tCausa;
    
    /**
     * @ORM\OneToMany(targetEntity="Actor", mappedBy="exped")
     * @ORM\JoinColumn(name="actor_rol", referencedColumnName="id")
     * @Annotation\Required(false)
     * @Annotation\Attributes({"type":"hidden"})
     */
    protected $actores;
    
    public function __construct() {
        $this->actores = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Consultar"})
     */
    public $submit;
    
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
    
    public function getActores() {
        return $this->actores;
    }
    
    public function setActores(\Doctrine\Common\Collections\ArrayCollection $actores = null) {
        $this->actores = $actores;
    }
    
    public function getActorByStActor($st_actor){
        
        $actores = new \Doctrine\Common\Collections\ArrayCollection();
        
        foreach ($this->getActores() as $k=>$actor){
            if (($actor->isStActor($st_actor)) and ($actor->__get('afecta') == 'si'))
                $actores->add($actor);
        }
        
        return $actores;
        
    }
    
    public function getActorStringByStActor($st_actor){
        $a = "";
        foreach ($this->getActorByStActor($st_actor) as $act)
            $a .= $act->nombre." ";
            
        return $a;
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
        $this->num = $data['num'];
        $this->anio = $data['anio'];
        $this->codigo = $data['codigo'];
        $this->num_exp_adm = $data['num_exp_adm'];
    }
 
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
        
}
