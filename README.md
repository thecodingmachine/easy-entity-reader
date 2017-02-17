Easy Entity Adapter
===================

This package targets Drupal 8.

It offers developers a friendly way of accessing their entities.

[![Latest Stable Version](https://poser.pugx.org/thecodingmachine/easy-entity-reader/v/stable)](https://packagist.org/packages/thecodingmachine/easy-entity-reader)
[![Total Downloads](https://poser.pugx.org/thecodingmachine/easy-entity-reader/downloads)](https://packagist.org/packages/thecodingmachine/easy-entity-reader)
[![Latest Unstable Version](https://poser.pugx.org/thecodingmachine/easy-entity-reader/v/unstable)](https://packagist.org/packages/thecodingmachine/easy-entity-reader)
[![License](https://poser.pugx.org/thecodingmachine/easy-entity-reader/license)](https://packagist.org/packages/thecodingmachine/easy-entity-reader)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodingmachine/easy-entity-reader/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/thecodingmachine/easy-entity-reader/?branch=1.0)
[![Build Status](https://travis-ci.org/thecodingmachine/easy-entity-reader.svg?branch=1.0)](https://travis-ci.org/thecodingmachine/easy-entity-reader)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/easy-entity-reader/badge.svg?branch=1.0&service=github)](https://coveralls.io/github/thecodingmachine/easy-entity-reader?branch=1.0)

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
