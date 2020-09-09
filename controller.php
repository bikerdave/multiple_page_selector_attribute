<?php
// Author: Ryan Hewitt - http://www.mesuva.com.au
namespace Concrete\Package\MultiplePageSelectorAttribute;

use \Concrete\Core\Package\Package;

class Controller extends Package {

	protected $pkgHandle = 'multiple_page_selector_attribute';
	protected $appVersionRequired = '8.0';
	protected $pkgVersion = '1.0';

	public function getPackageDescription() {
		return t("Attribute that allows the selection of multiple pages");
	}

	public function getPackageName() {
		return t("Multiple Page Selector Attribute");
	}

	public function install() {
        parent::install();
        $pkg = $this->app->make('Concrete\Core\Package\PackageService')->getByHandle('multiple_page_selector_attribute');

	    $factory = $this->app->make('Concrete\Core\Attribute\TypeFactory');
        $type = $factory->getByHandle('multiple_page_selector');
        if (!is_object($type)) {
            $type = $factory->add('multiple_page_selector', t('Multiple Page Selector'), $pkg);
        }

        $service = $this->app->make('Concrete\Core\Attribute\Category\CategoryService');
        $category = $service->getByHandle('collection')->getController();
        $category->associateAttributeKeyType($type);
    }
}
