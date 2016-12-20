<?php

namespace Drupal\easy_entity_reader;

use Drupal\Core\Entity\EntityInterface;

/**
 * Twig extension with some useful functions and filters.
 */
class TwigExtension extends \Twig_Extension
{
    /**
     * @var EntityWrapper
     */
    private $entityWrapper;

    public function __construct(EntityWrapper $entityWrapper)
    {
        $this->entityWrapper = $entityWrapper;
    }

  /**
   * {@inheritdoc}
   */
  public function getFunctions()
  {
      return [
          new \Twig_SimpleFunction('easy_entity', [$this, 'easyEntity']),
      ];
  }

  /**
   * {@inheritdoc}
   *
   * @deprecated
   */
  public function getName()
  {
      return 'easy_entity_reader';
  }

  /**
   * Wraps an entity object in a "easy" wrapper.
   *
   * @param EntityInterface $entity
   *
   * @return EasyEntityAdapter
   */
  public function easyEntity(EntityInterface $entity)
  {
      return $this->entityWrapper->wrap($entity);
  }
}
