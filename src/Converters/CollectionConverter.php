<?php

namespace Drupal\easy_entity_reader\Converters;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\field_collection\Plugin\Field\FieldType\FieldCollection;
use Drupal\easy_entity_reader\EntityWrapper;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\field_collection\Entity\FieldCollectionItem;

/**
 * Convert collection class to value.
 *
 * Class DefaultConverter.
 */
class CollectionConverter implements ConverterInterface
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
        $values = $value->getValue();
        if(isset($values['value'])) {
            $node = $this->entityManager->getStorage('field_collection_item')->load($values['value']);
            $test = $this->entityWrapper->wrap($node);
            if($node) {
                return $this->entityWrapper->wrap($node);
            }
        }
        else {
            $valuesFormat = [];
            foreach ($values as $k => $v) {
                if(is_array($v) && isset($v[0]))
                    $valuesFormat[$k]['x-default'] = $v[0];
            }
            $node = new FieldCollectionItem($valuesFormat, 'field_collection_item', $values['field_collection_item']->bundle());
            if($node) {
                return $this->entityWrapper->wrap($node);
            }
        }
        return [];
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
        return $value instanceof FieldCollection;
    }
}
