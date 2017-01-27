<?php

namespace Yosodog\PWTools\API;

use Yosodog\PWTools\Client;

class Trading
{
    /**
     * What resource are we working with.
     *
     * @var string
     */
    public $resource;

    /**
     * The average price of the resource.
     *
     * @var int
     */
    public $avgPrice;

    /**
     * Market index for all the resources.
     *
     * @var int
     */
    public $marketIndex;

    /**
     * Holds the Highest buying offer.
     *
     * @var
     */
    public $highestBuy;

    /**
     * Holds the information about the lowest selling offer.
     *
     * On the API, this is under "lowestbuy" but that makes no sense.
     *
     * @var \stdClass
     */
    public $lowestSell;

    /**
     * Trading constructor.
     *
     * Calls to the API and sorts everything for easy use
     *
     * @param string $resource
     */
    public function __construct(string $resource)
    {
        // TODO should I validate that the string given is a valid resource? Probably not... fuck it

        $client = new Client();

        $json = \json_decode($client->getPage("http://politicsandwar.com/api/tradeprice/resource={$resource}"));

        // Dunno if shit was successful or not cuz the API will just return steel if anything is wrong. thx sheepy
        // Set all the variables and convert them to their proper type
        $this->resource = $json->resource;
        $this->avgPrice = intval($json->avgprice);
        $this->marketIndex = intval($json->marketindex);

        // Store highestBuy and lowestSell in an anon class
        $tradeClass = new class {
            /**
             * @var string $date
             * @var int $nID
             * @var int $amount The amount of the resource being sold
             * @var int $price The PPU of the trade offer
             * @var int $totalValue The total value of the trade
             */
            public $date, $nID, $amount, $price, $totalValue;

            /**
             * Set the values for the trade
             *
             * @param \stdClass $stdClass
             */
            public function setValues(\stdClass $stdClass)
            {
                $this->date = $stdClass->date;
                $this->nID = intval($stdClass->nationid);
                $this->amount = intval($stdClass->amount);
                $this->price = intval($stdClass->price);
                $this->totalValue = $stdClass->totalvalue;
            }
        };

        $this->highestBuy = new $tradeClass;
        $this->highestBuy->setValues($json->highestbuy);
        $this->lowestSell = new $tradeClass;
        $this->lowestSell->setValues($json->lowestbuy);
    }
}