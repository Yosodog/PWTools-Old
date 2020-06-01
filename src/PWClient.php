<?php


namespace Yosodog\PWTools;


use GuzzleHttp\Client;
use Yosodog\PWTools\Exceptions\APIError;
use Yosodog\PWTools\Exceptions\MissingRequiredParam;
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
     * @throws APIError
     * @throws NotValidParam
     * @throws \JsonException
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
        $json = $this->callAPI("nations", $params);

        // If we get here without an exception, we know the request was successful. Now prepare to return
        $nations = new Nations($json->data);

        return $nations;
    }

    /**
     * Global method for the nation bank records API endpoint
     *
     * @param array $params
     * @return BankRecords
     * @throws APIError
     * @throws MissingRequiredParam
     * @throws NotValidParam
     * @throws \JsonException
     */
    public function nationBank(array $params) : BankRecords
    {
        $requiredParams = ["nation_id"];
        $optionalParams = [
            "format", "s_only", "r_only", "min_tx_id", "max_tx_id", "min_tx_date", "max_tx_date",
            "s_type", "r_type", "banker_id"];

        $optionalParams = array_merge($requiredParams, $optionalParams); // Merge the two so in the second check it'll pass

        $this->checkRequiredParams($params, $requiredParams);

        $this->checkIfParamsValid($params, $optionalParams);

        // Now that the parameters are validaed, let's call the API
        $json = $this->callAPI("nation-bank-recs", $params);

        $records = new BankRecords($json->data);

        return $records;

    }

    /**
     * Method to call the API
     *
     * @param string $endpoint
     * @param array $params
     * @return mixed
     * @throws APIError
     * @throws \JsonException
     */
    protected function callAPI(string $endpoint, $params = [])
    {
        $get = $this->client->get("http://politicsandwar.com/api/v2/{$endpoint}/".$this->queryBuilder($params))->getBody();

        // Decode JSON
        $json = json_decode($get, false, 512, JSON_THROW_ON_ERROR);

        $this->validateAPICall($json); // Check that the call was successful

        return $json;
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
     * Checks for accepted required parameters. Throws exception if a parameter is missing
     *
     * @param array $params
     * @param array $requiredParams
     * @throws MissingRequiredParam
     */
    protected function checkRequiredParams(array $params, array $requiredParams)
    {
        foreach ($requiredParams as $param)
        {
            if (array_key_exists($param, $params))
                continue;
            else
                throw new MissingRequiredParam($param . " is missing and is a required parameter");
        }
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