<?php

namespace Exped\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterInterface;

/**
 * TipoCausaGrupo
 *
 * @ORM\Entity
 * @ORM\Table(name="t_causa_grupo")
 */
class TipoCausaGrupo
{
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"hidden"})
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Attributes({"id":"tCausaGrupo"})
     * @Annotation\Attributes({"class":"felement"})
     * @Annotation\Options({"label":"Tipo Causa:","empty_option":""})
     * @Annotation\Filter({"name":"StripTags"})
     * @ORM\Column(type="string")
     * @ORM\Column(name="t_causa_grupo")
     */
    public $tCausaGrupo;
    
    
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
    
    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) 
    {
        $this->id = $data['id'];
        $this->t_causa = $data['t_causa'];
    }
 
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
        
}
