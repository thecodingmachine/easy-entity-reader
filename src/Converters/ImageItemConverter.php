<?php

namespace Drupal\easy_entity_reader\Converters;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\easy_entity_reader\EntityWrapper;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\image\Plugin\Field\FieldType\ImageItem;
use Drupal\easy_entity_reader\CompositeArrayAccess;

/**
 * Convert image class to value.
 *
 * Class DefaultConverter.
 */
class ImageItemConverter implements ConverterInterface
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
        $type = str_replace('default:', '', $value->getParent()->getSettings()['handler']);
        $node = $this->entityManager->getStorage($type)->load($values['target_id']);

        $frontArray = [];
        if (isset($values['alt'])) {
            $frontArray['alt'] = $values['alt'];
        }
        if (isset($values['title'])) {
            $frontArray['title'] = $values['title'];
        }
        if (isset($values['width'])) {
            $frontArray['width'] = $values['width'];
        }
        if (isset($values['height'])) {
            $frontArray['height'] = $values['height'];
        }
        $wrap = $this->entityWrapper->wrap($node);

        return new CompositeArrayAccess([$frontArray, $wrap]);
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
        return $value instanceof ImageItem;
    }
}
