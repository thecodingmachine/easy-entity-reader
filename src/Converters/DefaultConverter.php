<?php

namespace Drupal\easy_entity_reader\Converters;

use Drupal\Core\Field\FieldItemInterface;

/**
 * Convert the default class to value.
 *
 * Class DefaultConverter.
 */
class DefaultConverter implements ConverterInterface
{
    /**
     * @param FieldItemInterface $value
     */
    public function convert(FieldItemInterface $value)
    {
        return $value->getValue()['value'];
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
        return true;
    }
}
