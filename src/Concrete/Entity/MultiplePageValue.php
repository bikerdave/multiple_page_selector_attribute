<?php

namespace Concrete\Package\MultiplePageSelectorAttribute\Entity;

use Concrete\Core\Page\Page;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Concrete\Core\Entity\Attribute\Value\Value\AbstractValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="atMultiplePageSelector")
 */
class MultiplePageValue extends AbstractValue
{
    /**
     * @ORM\OneToMany(targetEntity="\Concrete\Package\MultiplePageSelectorAttribute\Entity\MultiplePageRecord", cascade={"persist", "remove"}, mappedBy="value")
     * @ORM\JoinColumn(name="avID", referencedColumnName="avID")
     */
    protected Collection $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function getPagesData(): Collection
    {
        return $this->pages;
    }

    /**
     * @return int[]
     */
    public function getPageCIDs(): array
    {
        $pages = [];

        foreach($this->pages as $cid) {
            $pages[] = $cid->getCID();
        }

        return $pages;
    }

    /**
     * @return Page[]
     */
    public function getPages(): array
    {
        $pages = [];

        foreach($this->pages as $cid) {
            $page = Page::getByID($cid->getCID());

            if ($page && !$page->isInTrash()) {
                $pages[] = $page;
            }
        }

        return $pages;
    }

    public function setPageCID(Collection $pages): void
    {
        $this->pages = $pages;
    }

    public function __toString()
    {
        return '-';
    }
}
