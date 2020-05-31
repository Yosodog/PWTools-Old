<?php


namespace Yosodog\PWTools;


/**
 * Class BankRecord
 *
 * Class that holds an individual bank record
 *
 * @package Yosodog\PWTools
 */
class BankRecord
{
    public $id;
    public $timestamp;
    public $senderID;
    public $senderType;
    public $receiverID;
    public $receiverType;
    public $bankerNID;
    public $note;
    public $money;
    public $coal;
    public $oil;
    public $uranium;
    public $iron;
    public $bauxite;
    public $leader;
    public $gasoline;
    public $munitions;
    public $steel;
    public $aluminum;
    public $food;

    /**
     * BankRecord constructor.
     * @param \stdClass $record
     */
    public function __construct(\stdClass $record)
    {
        $this->id = $record->tx_id;
        $this->timestamp = $record->tx_datetime;
        $this->senderID = $record->sender_id;
        $this->senderType = $record->sender_type;
        $this->receiverID = $record->receiver_id;
        $this->receiverType = $record->receiver_type;
        $this->bankerNID = $record->banker_nation_id;
        $this->note = $record->note;
        $this->money = $record->money;
        $this->coal = $record->coal;
        $this->oil = $record->oil;
        $this->uranium = $record->uranium;
        $this->iron = $record->iron;
        $this->bauxite = $record->bauxite;
        $this->lead = $record->lead;
        $this->gasoline = $record->gasoline;
        $this->munitions = $record->munitions;
        $this->steel = $record->steel;
        $this->aluminum = $record->aluminum;
        $this->food = $record->food;
    }
}