<?php

namespace Drupal\easy_entity_reader;

use Drupal\easy_entity_reader\Converters\ConverterInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldItemInterface;

/**
 * Wrap value type to object to convert it.
 *
 * Class EntityWrapper.
 */
class EntityWrapper
{
    /**
     * @var ConverterInterface[]
     */
    private $converters;

    public function registerConverter(ConverterInterface $converter)
    {
        $this->converters[] = $converter;
    }

    public function convert(FieldItemInterface $value)
    {
        foreach ($this->converters as $converter) {
            if ($converter->canConvert($value)) {
                return $converter->convert($value);
            }
        }
        throw new \LogicException('Could not find a converter for value. Value type: '.get_class($value));
    }

    public function wrap(EntityInterface $entity) : EasyEntityAdapter
    {
        return new EasyEntityAdapter($entity, $this);
    }
}
