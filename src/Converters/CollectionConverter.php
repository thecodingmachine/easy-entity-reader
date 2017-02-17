<?php

namespace Drupal\easy_entity_reader\Converters;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\field_collection\Plugin\Field\FieldType\FieldCollection;
use Drupal\easy_entity_reader\EntityWrapper;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\field_collection\Entity\FieldCollectionItem;
use Drupal\Core\Language\LanguageInterface;

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
        }
        else {
            /* 
             * If there is a default language this is because there is
             * a field collection in another. This remove the language default
             */

            if(isset($values[LanguageInterface::LANGCODE_DEFAULT])) {
                $values = $values[LanguageInterface::LANGCODE_DEFAULT];
            }
            $valuesFormat = [];

            //If the array is not format with language, the value is not store in object
            // Change the index to use the default value of language
            $this->convertArrayToValues($values, $valuesFormat);
            $node = new FieldCollectionItem($valuesFormat, 'field_collection_item', $values['field_collection_item']->bundle());
        }
        
        if($node) {
            return $this->entityWrapper->wrap($node);
        }
        else {
            return [];
        }
    }
    
    private function convertArrayToValues($toConvert, &$convert) {
        foreach ($toConvert as $k => $v) {
            if(is_array($v) && isset($v[0]) && count($v) == 1) {
                $convert[$k][LanguageInterface::LANGCODE_DEFAULT] = $v[0];
            }
            elseif(count($v) > 1) {
                $convert[$k][LanguageInterface::LANGCODE_DEFAULT] = [];
                $this->convertArrayToValues($v, $convert[$k][LanguageInterface::LANGCODE_DEFAULT]);
            }
            else {
                $convert[$k] = $v;
            }
        }
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
