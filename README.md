# Multiple Page Selector Attribute

A multiple page selector attribute for Concrete CMS v9.

Once installed, you can fetch the attribute in a page template one of two ways:

```php
$products = $c->getAttribute('related_products')->getPages();
// $products now contains an array of collection (page) objects

// or
$products = $c->getAttribute('related_products')->getPageCIDs();
// $products now contains an array of page IDs

```

An example of using the attribute would be:
```php
<?php $relatedPagesAttribute = $c->getAttribute('related_pages'); ?>

<?php if ($relatedPagesAttribute): ?>
    <?php $relatedPages = $relatedPagesAttribute->getPages(); ?>

    <?php if (!empty($relatedPages)): ?>
        <ul>
            <?php foreach ($relatedPages as $relatedPage): ?>
                <li><a href="<?= $relatedPage->getCollectionLink(); ?>"><?= h($relatedPage->getCollectionName()); ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>
```
