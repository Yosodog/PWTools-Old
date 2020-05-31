<?php


namespace Yosodog\PWTools;


class PWClient
{
    /**
     * PW's API Key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * PWClient constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }
}