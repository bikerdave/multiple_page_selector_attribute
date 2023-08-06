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
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $avrID;

    /**
     * @ORM\ManyToOne(targetEntity="MultiplePageValue", inversedBy="clergy")
     * @ORM\JoinColumn(name="avID", referencedColumnName="avID")
     */
    protected MultiplePageValue $value;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected int $cID;

    public function getCID(): int
    {
        return $this->cID;
    }

    public function setCID(int $cID): void
    {
        $this->cID = $cID;
    }

    public function getAttributeValue(): MultiplePageValue
    {
        return $this->value;
    }

    public function setAttributeValue(MultiplePageValue $value): void
    {
        $this->value = $value;
    }
}

