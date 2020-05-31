<?php


namespace Yosodog\PWTools;


/**
 * Class BankRecords
 *
 * Class that is iterable that holds multiple bank records from any bank records endpoint
 *
 * @package Yosodog\PWTools
 */
class BankRecords implements \Iterator
{
    private $position = 0;

    private $records = [];

    /**
     * BankRecords constructor.
     *
     * @param array $records
     */
    public function __construct(array $records)
    {
        $collection = [];

        foreach ($records as $record)
        {
            array_push($this->records, new BankRecord($record));
        }
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->records[$this->position];
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
        return isset($this->records[$this->position]);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->position = 0;
    }
}