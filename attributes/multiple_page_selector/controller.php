<?php

namespace Concrete\Package\MultiplePageSelectorAttribute\Attribute\MultiplePageSelector;

use Concrete\Core\Attribute\Controller as AttributeTypeController;

use Concrete\Package\MultiplePageSelectorAttribute\Entity\MultiplePageRecord;
use Concrete\Package\MultiplePageSelectorAttribute\Entity\MultiplePageValue;
use Concrete\Core\Attribute\FontAwesomeIconFormatter;

class Controller extends AttributeTypeController {

    protected $searchIndexFieldDefinition = array('type' => 'text', 'options' => array('default' => '', 'notnull' => false));

    public function getIconFormatter()
    {
        return new FontAwesomeIconFormatter('link');
    }

    public function getSearchIndexValue()
    {
        return '';
    }

    public function getAttributeValueClass()
    {
        return MultiplePageValue::class;
    }

    public function form()
    {
        $this->requireAsset('core/sitemap');
        $this->requireAsset('javascript', 'vue');

        $data = [];

        if (is_object($this->attributeValue)) {
            $pages = $this->attributeValue->getValue()->getPageCIDs();

            foreach($pages as $p) {
                $data[] = [
                    'cID' => $p->getCID(),
                ];
            }
        }

        $this->set('pages', $data);

        $uniquestring = $this->app->make('helper/validation/identifier')->getString(18);
        $this->set('uniqueID', $uniquestring);
    }

    public function createAttributeValueFromRequest()
    {
        $data = $this->post();

        $values = [];

        if (!empty($data)) {
            foreach ($data as $key => $d) {
                if (is_array($d)) {
                    foreach ($d as $num => $t) {
                        if (isset($values[$num])) {
                            $values[$num][$key] = $t;
                        } else {
                            $values[$num] = [$key => $t];
                        }
                    }
                }
            }
        }

        return $this->createAttributeValue($values);
    }


    public function createAttributeValue($values)
    {
        $av = new MultiplePageValue();

        if (!empty($values)) {
            foreach ($values as $value) {
                $pageRecord = new MultiplePageRecord();
                $pageRecord->setCID($value['cID']);
                $pageRecord->setAttributeValue($av);
                $av->getPageCIDs()->add($pageRecord);
            }
        }

        return $av;
    }



    public function getDisplayValue()
    {
        $value = $this->attributeValue->getValueObject();
        if ($value) {
            return $value->getPageCIDs();
        }
    }

}
