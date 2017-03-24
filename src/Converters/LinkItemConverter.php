<?php

namespace Drupal\easy_entity_reader\Converters;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\link\Plugin\Field\FieldType\LinkItem;
use Drupal\Core\Url;

/**
 * Convert image class to value.
 *
 * Class DefaultConverter.
 */
class LinkItemConverter implements ConverterInterface
{
    /**
     * @param FieldItemInterface $value
     */
    public function convert(FieldItemInterface $value)
    {
        $values = $value->getValue();
        $url = Url::fromUri($values['uri'], $values['options']);
        $values['url'] = $url->toString();
        return $values;
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
        return $value instanceof LinkItem;
    }
}
