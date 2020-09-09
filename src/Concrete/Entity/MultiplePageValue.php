<?php
namespace Concrete\Package\MultiplePageSelectorAttribute\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Concrete\Core\Entity\Attribute\Value\Value\AbstractValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="atMultiplePageSelector")
 */
class MultiplePageValue extends AbstractValue
{
    /**
     * @ORM\OneToMany(targetEntity="\Concrete\Package\MultiplePageSelectorAttribute\Entity\MultiplePageRecord",
     *     cascade={"persist", "remove"}, mappedBy="value")
     * @ORM\JoinColumn(name="avID", referencedColumnName="avID")
     */
    protected $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function getPageCIDs()
    {
        return $this->pages;
    }

    public function getPages() {
        $pages = [];

        foreach($this->pages as $cid) {
            $page = \Page::getByID($cid->getCID());

            if ($page && !$page->isInTrash()) {
                $pages[] = $page;
            }
        }

        return $pages;
    }

    public function setPageCID($pages)
    {
        $this->pages = $pages;
    }

    public function __toString()
    {
        $html = '-';

        return $html;
    }
}
