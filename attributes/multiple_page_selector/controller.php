<?php

namespace Concrete\Package\MultiplePageSelectorAttribute\Attribute\MultiplePageSelector;

use Concrete\Core\Attribute\Controller as AttributeTypeController;
use Concrete\Core\Attribute\FontAwesomeIconFormatter;
use Concrete\Package\MultiplePageSelectorAttribute\Entity\MultiplePageRecord;
use Concrete\Package\MultiplePageSelectorAttribute\Entity\MultiplePageValue;
use Illuminate\Contracts\Container\BindingResolutionException;

class Controller extends AttributeTypeController
{
    protected $searchIndexFieldDefinition = [
        'type' => 'text',
        'options' => [
            'default' => '',
            'notnull' => false,
        ],
    ];

    public function getIconFormatter(): FontAwesomeIconFormatter
    {
        return new FontAwesomeIconFormatter('link');
    }

    public function getSearchIndexValue(): string
    {
        return '';
    }

    public function getAttributeValueClass(): string
    {
        return MultiplePageValue::class;
    }

    /**
     * @throws BindingResolutionException
     */
    public function form(): void
    {
        $this->requireAsset('core/sitemap');
        $this->requireAsset('javascript', 'vue');

        $data = [];

        if (is_object($this->attributeValue)) {
            /** @var MultiplePageValue $value */
            $value = $this->attributeValue->getValue();
            $pages = $value->getPagesData();

            foreach($pages as $p) {
                $data[] = [
                    'cID' => $p->getCID(),
                ];
            }
        }

        $this->set('pages', $data);

        $uniqueString = $this->app->make('helper/validation/identifier')->getString(18);
        $this->set('uniqueID', $uniqueString);
    }

    public function createAttributeValueFromRequest(): MultiplePageValue
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

    /**
     * @param array $mixed
     */
    public function createAttributeValue(mixed $mixed): MultiplePageValue
    {
        $av = new MultiplePageValue();

        if (!empty($mixed)) {
            foreach ($mixed as $value) {
                $pageRecord = new MultiplePageRecord();
                $pageRecord->setCID($value['cID']);
                $pageRecord->setAttributeValue($av);
                $collection = $av->getPagesData();
                /** @noinspection PhpParamsInspection */
                $collection->add($pageRecord);
            }
        }

        return $av;
    }

    public function getDisplayValue(): string
    {
        /** @var MultiplePageValue $value */
        $value = $this->attributeValue->getValueObject();
        if ($value) {
            $pageNames = [];
            $pages = $value->getPages();
            $count = 0;

            foreach ($pages as $p) {
                if ($count < 5) {
                    $pageNames[] = $p->getCollectionName();
                } else {
                    $pageNames[] = t('+ %s more', count($pages) - $count);
                    break;
                }
                $count++;
            }

            return implode(', ', $pageNames);
        }

        return '';
    }
}
