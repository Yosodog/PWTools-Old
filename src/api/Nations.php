<?php

namespace Yosodog\PWTools\API;

use Yosodog\PWTools\Client;

class Nations
{
    /**
     * Holds the client which we'll do stuff with
     *
     * @var Client
     */
    protected $client;

    /**
     * Holds the result when we call the API.
     *
     * @var \stdClass
     */
    public $json;

    /**
     * Nations constructor.
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
        $this->json = \json_decode($this->client->getPage("https://politicsandwar.com/api/nations/"));
    }

    /**
     * Gets all the nation IDs for everyone in an alliance
     *
     * @param int $aID Alliance ID
     * @return array
     */
    public static function getAllianceNationIDs(int $aID) : array
    {
        $nations = new self;
        $nations->callAPI();

        $nIDs = [];

        foreach ($nations->json->nations as $nation)
        {
            if ($nation->allianceid == $aID)
                array_push($nIDs, $nation->nationid);
        }

        return $nIDs;
    }
}