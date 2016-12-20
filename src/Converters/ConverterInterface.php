<?php

namespace Drupal\easy_entity_reader\Converters;

use Drupal\Core\Field\FieldItemInterface;

/**
 * Interface to convert entity to value.
 *
 * Class ConverterInterface.
 */
interface ConverterInterface
{
    /**
     * @param mixed $value
     */
    public function convert(FieldItemInterface $value);

    /**
     * Returns whether the FieldItemInterface can be converted or not.
     *
     * @param FieldItemInterface $value
     *
     * @return bool
     */
    public function canConvert(FieldItemInterface $value) : bool;
}
