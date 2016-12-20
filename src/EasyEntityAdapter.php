<?php

namespace Drupal\easy_entity_reader;

use Drupal\Core\Entity\EntityInterface;

/**
 * Adapts an entity class in an easy access array.
 *
 * Class EntityAdapter.
 */
class EasyEntityAdapter implements \ArrayAccess
{
    /**
     * @var EntityInterface
     */
    private $entity;

    /**
     * @var EntityWrapper
     */
    private $entityWrapper;

    /**
     * @param EntityInterface $entity
     * @param EntityWrapper   $entityWrapper
     */
    public function __construct(EntityInterface $entity, EntityWrapper $entityWrapper)
    {
        $this->entity = $entity;
        $this->entityWrapper = $entityWrapper;
    }

    /**
     * @param $offset
     */
    public function offsetExists($offset)
    {
        return isset($this->entity->getFields()[$offset]);
    }

    /**
     * @param $offset
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            if (isset($this->entity->$offset)) {
                $values = $this->entity->$offset;
                $cardinality = $values->getDataDefinition()->getFieldStorageDefinition()->getCardinality();
                if (1 === $cardinality) {
                    if ($values[0] === null) {
                        return null;
                    }

                    return $this->entityWrapper->convert($values[0]);
                } else {
                    return array_map([$this->entityWrapper, 'convert'], iterator_to_array($values));
                }
            }
        } else {
            return null;
        }
        throw new \Exception('The index "'.$offset.'" doesn\'t exist');
    }

    /**
     * @param $offset
     * @param $value
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception('Not supported');
    }

    /**
     * @param $offset
     */
    public function offsetUnset($offset)
    {
        throw new \Exception('Not supported');
    }
}
