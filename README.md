# Multiple Page Selector Attribute

A multiple page selector attribute for concrete5 version 8.

Once installed, you can fetch the attribute in a page template one of two ways:

```php
$products = $c->getAttribute('related_products')->getPages();
// $products now contains an array of collection (page) objects

// or 
$products = $c->getAttribute('related_products')->getPageCIDs();
// $products now contains an array of page IDs

```

