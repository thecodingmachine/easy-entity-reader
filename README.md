Easy Entity Adapter
===================

This package targets Drupal 8.

It offers developers a friendly way of accessing their entities.

[![Latest Stable Version](https://poser.pugx.org/thecodingmachine/easy.entity.adapter/v/stable)](https://packagist.org/packages/thecodingmachine/easy.entity.adapter)
[![Total Downloads](https://poser.pugx.org/thecodingmachine/easy.entity.adapter/downloads)](https://packagist.org/packages/thecodingmachine/easy.entity.adapter)
[![Latest Unstable Version](https://poser.pugx.org/thecodingmachine/easy.entity.adapter/v/unstable)](https://packagist.org/packages/thecodingmachine/easy.entity.adapter)
[![License](https://poser.pugx.org/thecodingmachine/easy.entity.adapter/license)](https://packagist.org/packages/thecodingmachine/easy.entity.adapter)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodingmachine/easy.entity.adapter/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/thecodingmachine/easy.entity.adapter/?branch=1.0)
[![Build Status](https://travis-ci.org/thecodingmachine/easy.entity.adapter.svg?branch=1.0)](https://travis-ci.org/thecodingmachine/easy.entity.adapter)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/easy.entity.adapter/badge.svg?branch=1.0&service=github)](https://coveralls.io/github/thecodingmachine/easy.entity.adapter?branch=1.0)


Why?
----

Drupal has kind of a very verbose syntax to access entities.

Fed up of typing code like this?

```php
$entity->get('field_my_field')->getValue()[0]['value']
```

This package has the solution for you!

How does it works?
------------------

This package registers in the Drupal container a new service: `easy_entity_adapter.wrapper`.

This service can "wrap" an entity into another object that is way easier to access. You can access values of the "wrapped" entity directly (using the array access notation).

Here is a sample:

```php
// Let's assume you have a $entity variable containing an entity.

$wrapper = \Drupal::get('easy_entity_adapter.wrapper');

$easyEntity = $wrapper->wrap($entity);

// Now, you can access parts of your entity very easily.

$title = $easyEntity['title']; // $title is directly a string
$references = $easyEntity['my_custom_references']; // If the cardinality of the 'my_custom_references' is > 1, then the $references is automatically an array.
// Even better, referenced nodes are automatically fetched and converted into wrapped entities.

// So you can do something like:
$titleOfTheReferencedNode = $easyEntity['my_custom_references'][0]['title'];
```

Install
-------

Simply use:

```php
composer require thecodingmachine/easy.entity.adapter
```

Twig integration
----------------

From Twig, you can wrap an entity into the adapter using the `easy_entity` function.
 
For instance:

```twig
{{ easy_entity(node).title }}
```
