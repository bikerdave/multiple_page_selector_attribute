<?php
namespace Concrete\Package\MultiplePageSelectorAttribute\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="atMultiplePageSelectorRecords")
 */
class MultiplePageRecord
{
    /**
     * @ORM\Id @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $avrID;

    /**
     * @ORM\ManyToOne(targetEntity="MultiplePageValue", inversedBy="clergy")
     * @ORM\JoinColumn(name="avID", referencedColumnName="avID")
     */
    protected $value;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $cID;

    /**
     * @return mixed
     */
    public function getCID()
    {
        return $this->cID;
    }

    /**
     * @param mixed $cID
     */
    public function setCID($cID)
    {
        $this->cID = $cID;
    }

    /**
     * @return mixed
     */
    public function getAttributeValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setAttributeValue($value)
    {
        $this->value = $value;
    }
}

