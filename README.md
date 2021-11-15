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

An example of using the attribute would be:
```
$relatedPages = $c->getAttribute('related_pages')->getPages();

if (!empty($relatedPages)) { 
   echo '<ul>';
   foreach($relatedPages as $relatedPage) {
       echo '<li><a href="' . \Concrete\Core\Support\Facade\Url::to($relatedPage) . '">'. h($relatedPage->getCollectionName()). '</a></li>';
   }
   echo '</ul>';
}
```
