<?php

namespace Drupal\easy_entity_reader;

use Drupal\Core\Entity\EntityInterface;

/**
 * Adapts an entity class in an easy access array
 * 
 * Class EntityAdapter.
 *
 */
class EasyEntityAdapter implements \ArrayAccess {

    /**
     * 
     * @var EntityInterface
     */
    private $entity;

    /**
     *
     * @var EntityWrapper
     */
    private $entityWrapper;
    
    /**
     * 
     * @param EntityInterface $entity
     * @param EntityWrapper $entityWrapper
     */
    public function __construct(EntityInterface $entity, EntityWrapper $entityWrapper)
    {
        $this->entity = $entity;
        $this->entityWrapper = $entityWrapper;
    }
    
    /**
     * @param $offset
     */
    public function offsetExists ($offset)
    {
        return isset($this->entity->$offset);
    }
    
    /**
     * @param $offset
     */
    public function offsetGet ($offset)
    {
        if(isset($this->entity->$offset)) {
            $values = $this->entity->$offset;
            $cardinality = $values->getDataDefinition()->getFieldStorageDefinition()->getCardinality();
            if(1 === $cardinality) {
                return $this->entityWrapper->convert($values[0]);
            }
            else {
                return array_map([$this->entityWrapper, 'convert'], iterator_to_array($values));
            }
        }
         throw new \Exception('The index "'.$offset.'" doesn\'t exist');   
    }
    
    /**
     * @param $offset
     * @param $value
     */
    public function offsetSet ($offset, $value)
    {
        
    }
    
    /**
     * @param $offset
     */
    public function offsetUnset ($offset)
    {
        
    }
}
