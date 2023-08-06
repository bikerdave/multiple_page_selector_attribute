<?php

namespace Concrete\Package\MultiplePageSelectorAttribute;

use Concrete\Core\Package\Package;
use Illuminate\Contracts\Container\BindingResolutionException;

class Controller extends Package
{
    /** @var string */
    protected $appVersionRequired = '9.0';

	protected string $pkgHandle = 'multiple_page_selector_attribute';

	protected string $pkgVersion = '9.1.0.0';

    public function getPackageName(): string
    {
        return t("Multiple Page Selector Attribute");
    }

	public function getPackageDescription(): string
    {
		return t("Attribute that allows the selection of multiple pages");
	}

    /**
     * @throws BindingResolutionException
     */
    public function install(): void
    {
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
