<?php

namespace Drupal\easy_entity_reader;

/**
 * Composite to read an array or a wrapper.
 *
 * Class EntityAdapter.
 */
class CompositeArrayAccess implements \ArrayAccess
{
    /**
     * @var array
     */
    private $arrays;

    /**
     * @param array $arrays
     */
    public function __construct(array $arrays)
    {
        $this->arrays = $arrays;
    }

    /**
     * @param $offset
     */
    public function offsetExists($offset)
    {
        return isset($this->entity->$offset);
    }

    /**
     * @param $offset
     */
    public function offsetGet($offset)
    {
        foreach ($this->arrays as $array) {
            if (isset($array[$offset])) {
                return $array[$offset];
            }
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
