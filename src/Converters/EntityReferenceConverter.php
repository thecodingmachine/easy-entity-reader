<?php

namespace Drupal\easy_entity_reader\Converters;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\EntityReferenceItem;
use Drupal\easy_entity_reader\EntityWrapper;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Convert the default class to value.
 *
 * Class DefaultConverter.
 */
class EntityReferenceConverter implements ConverterInterface
{
    /**
     * @var EntityWrapper
     */
    private $entityWrapper;

    /**
     * @var EntityTypeManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityWrapper              $entityWrapper
     * @param EntityTypeManagerInterface $entityManager
     */
    public function __construct(EntityWrapper $entityWrapper,
        EntityTypeManagerInterface $entityManager)
    {
        $this->entityWrapper = $entityWrapper;
        $this->entityManager = $entityManager;
    }

    /**
     * @param FieldItemInterface $value
     */
    public function convert(FieldItemInterface $value)
    {
        $type = str_replace('default:', '', $value->getParent()->getSettings()['handler']);
        $node = $this->entityManager->getStorage($type)->load($value->getValue()['target_id']);

        return $this->entityWrapper->wrap($node);
    }

    /**
     * Returns whether the FieldItemInterface can be converted or not.
     *
     * @param FieldItemInterface $value
     *
     * @return bool
     */
    public function canConvert(FieldItemInterface $value) : bool
    {
        return $value instanceof EntityReferenceItem;
    }
}
