<?php


namespace Yosodog\PWTools;


use GuzzleHttp\Client;
use Yosodog\PWTools\Exceptions\APIError;
use Yosodog\PWTools\Exceptions\NotValidParam;

/**
 * Class PWClient
 *
 * Class that interfaces between us and PW
 *
 * @package Yosodog\PWTools
 */
class PWClient
{
    /**
     * PW's API Key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Client that we'll use to make HTTP requests
     *
     * @var Client
     */
    protected $client;

    /**
     * PWClient constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client();
    }

    /**
     * Global method to call and customize the 'nations' API endpoint
     *
     * @param array $params
     * @return Nations
     * @throws NotValidParam
     */
    public function nations(array $params = []) : Nations
    {
        // Setup a list of accepted parameters for this API endpoint
        $acceptedParams = [
            "format", "alliance_id", "alliance_position", "date_created", "color", "v_mode", "min_score",
            "max_score", "cities", "min_cities", "max_cities"
        ];

        // Now check if the parameters passed here is valid
        $this->checkIfParamsValid($params, $acceptedParams);

        // Now call the API
        $get = $this->client->get("politicsandwar.com/api/v2/nations/".$this->queryBuilder($params))->getBody();

        // Decode JSON
        $json = json_decode($get);

        $this->validateAPICall($json);

        // If we get here without an exception, we know the request was successful. Now prepare to return
        $nations = new Nations($json->data);

        return $nations;
    }

    /**
     * Checks if the parameters passed are valid
     *
     * @param array $params
     * @param array $acceptedParams
     * @return bool
     * @throws NotValidParam
     */
    protected function checkIfParamsValid(array $params, array $acceptedParams) : bool
    {
        foreach ($params as $param => $value)
        {
            if (! in_array($param, $acceptedParams))
                throw new NotValidParam($param . " is not a valid parameter for this endpoint");
        }

        return true;
    }

    /**
     * Method that builds the query for an API call
     *
     * @param array $params
     * @return string
     */
    protected function queryBuilder(array $params) : string
    {
        $query = $this->apiKey."/";

        foreach ($params as $param => $value)
            $query .= "&{$param}={$value}";

        return $query;
    }

    /**
     * Method to check if the API request was successful
     *
     * @param \stdClass $json
     * @return bool
     * @throws APIError
     */
    protected function validateAPICall(\stdClass $json) : bool
    {
        if ($json->api_request->success == true)
            return true;
        else
            throw new APIError($json->api_request->error_msg);
    }
}