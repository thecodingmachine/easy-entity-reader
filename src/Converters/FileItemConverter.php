<?php

namespace Drupal\easy_entity_reader\Converters;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\EntityReferenceItem;
use Drupal\easy_entity_reader\EntityWrapper;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\file\Plugin\Field\FieldType\FileItem;

/**
 * Convert the file item class to value.
 *
 * Class FileItemConverter.
 */
class FileItemConverter implements ConverterInterface
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
        $node = null;
        $type = str_replace('default:', '', $value->getParent()->getSettings()['handler']);
        if(isset($value->getValue()['fids'][0])) {
            $node = $this->entityManager->getStorage($type)->load($value->getValue()['fids'][0]);
        }
        if($node !== null) {
            return $this->entityWrapper->wrap($node);
        }
        else {
            return null;
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
        return $value instanceof FileItem;
    }
}
