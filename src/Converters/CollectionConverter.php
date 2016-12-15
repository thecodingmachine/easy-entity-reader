<?php

namespace Drupal\easy_entity_reader\Converters;


use Drupal\easy_entity_reader\Converters\ConverterInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\field_collection\Plugin\Field\FieldType\FieldCollection;
use Drupal\easy_entity_reader\EntityWrapper;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Convert the default class to value
 *
 * Class DefaultConverter.
 *
 */
class CollectionConverter implements ConverterInterface {

    /**
     * 
     * @var EntityWrapper
     */
    private $entityWrapper;

    /**
     *
     * @var EntityTypeManagerInterface
     */
    private $entityManager;
    
    /**
     * 
     * @param EntityWrapper $entityWrapper
     * @param EntityTypeManagerInterface $entityManager
     */
    public function __construct(EntityWrapper $entityWrapper,
                            EntityTypeManagerInterface $entityManager) {
        $this->entityWrapper = $entityWrapper;
        $this->entityManager = $entityManager;
    }
    
    /**
     *
     * @param FieldItemInterface $value
     */
    public function convert(FieldItemInterface $value) {
        $node = $this->entityManager->getStorage('field_collection_item')->load($value->getValue()['value']);
        return $this->entityWrapper->wrap($node);
    }
    
    /**
     * Returns whether the FieldItemInterface can be converted or not.
     *
     * @param FieldItemInterface $value
     * @return bool
     */
    public function canConvert(FieldItemInterface $value) : bool
    {
        return $value instanceof FieldCollection;
    }
}