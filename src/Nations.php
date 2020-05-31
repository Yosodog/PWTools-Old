<?php


namespace Yosodog\PWTools;


/**
 * Class Nations
 *
 * Class used for the Nations endpoint. Holds a bunch of Nation classes and is iterable
 *
 * @package Yosodog\PWTools
 */
class Nations implements \Iterator
{
    private $position = 0;

    private $nations;

    /**
     * Nations constructor.
     * @param array $nations
     */
    public function __construct(array $nations)
    {
        // Take the array of nations and create new nation classes
        $collection = [];

        foreach ($nations as $nation)
        {
            array_push($collection, new Nation($nation));
        }

        $this->nations = $collection;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->nations[$this->position];
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return isset($this->nations[$this->position]);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->position = 0;
    }
}