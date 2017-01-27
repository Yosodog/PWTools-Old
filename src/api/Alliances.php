<?php

namespace Yosodog\PWTools\API;


use Yosodog\PWTools\Client;

class Alliances
{
    /**
     * Holds the result when we call the API.
     *
     * @var \stdClass
     */
    public $json;
    /**
     * Holds all of the alliance IDs in the game
     *
     * Call getAllianceIDs() to fill this
     *
     * @var array
     */
    public $aIDs = [];
    /**
     * Holds the client which we'll do stuff with
     *
     * @var Client
     */
    protected $client;

    /**
     * Alliances constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->callAPI();
    }

    /**
     * Calls the API to /api/nations, returns a JSON result, and parses the JSON.
     */
    protected function callAPI()
    {
        $this->json = \json_decode($this->client->getPage("https://politicsandwar.com/api/alliances/"));
    }

    /**
     * Gets all of the alliance IDs and stores them in $this->aIDs
     */
    public function getAllianceIDs()
    {
        foreach ($this->json->alliances as $alliance)
            array_push($this->aIDs, $alliance->id);
    }
}