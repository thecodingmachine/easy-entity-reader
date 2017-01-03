<?php

namespace Drupal\easy_entity_reader\Converters;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\field_collection\Plugin\Field\FieldType\FieldCollection;
use Drupal\easy_entity_reader\EntityWrapper;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\color_field\Plugin\Field\FieldType\ColorFieldType;

/**
 * Convert ColorFieldType class to value.
 *
 * Class ColorFieldConverter.
 */
class ColorFieldConverter implements ConverterInterface
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
        return $value->getValue();
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
        return $value instanceof ColorFieldType;
    }
}
