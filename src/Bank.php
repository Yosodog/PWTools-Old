<?php

namespace Yosodog\PWTools;

use PHPHtmlParser\Dom;

class Bank
{
    /**
     * @var int
     * @var int $food
     * @var int $coal
     * @var int $oil
     * @var int $uranium
     * @var int $lead
     * @var int $iron
     * @var int $bauxite
     * @var int $gasoline
     * @var int $munitions
     * @var int $steel
     * @var int $aluminum
     */
    public $money = 0;
    public $food = 0;
    public $coal = 0;
    public $oil = 0;
    public $uranium = 0;
    public $lead = 0;
    public $iron = 0;
    public $bauxite = 0;
    public $gasoline = 0;
    public $munitions = 0;
    public $steel = 0;
    public $aluminum = 0;

    /**
     * The person/alliance the bank request should be sent to. Has to be exact.
     *
     * @var string
     */
    public $recipient;

    /**
     * If the request is to be sent to a nation or alliance.
     *
     * Defaults to Nation. Set to Alliance if it's being sent to an alliance
     *
     * @var string
     */
    public $type = 'Nation';

    /**
     * The note added alongside the bank request.
     *
     * @var string
     */
    public $note = '';

    /**
     * Store the CSRF token for the request.
     *
     * @var string
     */
    protected $token;

    /**
     * An array that contains the data that will be sent in the post request.
     *
     * @var array
     */
    protected $postData = [];

    /**
     * Holds the PWClient.
     *
     * @var Client
     */
    protected $client;

    /**
     * Stores the alliance ID.
     *
     * @var int
     */
    public $aID;

    /**
     * PWBank constructor.
     *
     * @param Client $client
     * @param int $allianceID
     */
    public function __construct(Client $client, int $allianceID)
    {
        $this->client = $client;
        $this->aID = $allianceID;
    }

    /**
     * The function that gathers everything and sends out the money.
     *
     * @return bool
     * @throws \Exception
     */
    public function send() : bool
    {
        // Check to see if the recipient is filled out
        if (empty($this->recipient))
            throw new \Exception("Couldn't send -> Recipient empty");
        $this->getToken();
        $this->setupPost();

        $this->sendPOST();

        return true; // TODO check if the request was successful. It's easy, just :effort: lol
    }

    /**
     * Gets the CSRF token from PW to send.
     *
     * Gets the token from the city page because it loads slightly faster
     *
     * @throws \Exception
     */
    protected function getToken()
    {
        $this->token = $this->client->getToken($this->aID);
    }

    /**
     * Takes all the data needed and puts it into the post array so we can send it along.
     *
     * @throws \Exception
     */
    protected function setupPost()
    {
        // Check if the token is setup
        if (empty($this->token))
            throw new \Exception('Token not set. Run getToken() first');
        $this->postData = [
            'withmoney' => $this->money,
            'withfood' => $this->food,
            'withcoal' => $this->coal,
            'withoil' => $this->oil,
            'withuranium' => $this->uranium,
            'withlead' => $this->lead,
            'withiron' => $this->iron,
            'withbauxite' => $this->bauxite,
            'withgasoline' => $this->gasoline,
            'withmunitions' => $this->munitions,
            'withsteel' => $this->steel,
            'withaluminum' => $this->aluminum,
            'withtype' => $this->type,
            'withrecipient' => $this->recipient,
            'withnote' => $this->note,
            'withsubmit' => 'Withdraw',
            'token' => $this->token,
        ];

    }

    /**
     * Sends the post data completing the request.
     *
     * @throws \Exception
     */
    protected function sendPOST()
    {
        // Check if the postData is empty
        if (empty($this->postData))
            throw new \Exception('Post data empty. Run setupPOST() first');
        $x = $this->client->sendPOST("https://politicsandwar.com/alliance/id={$this->aID}&display=bank", $this->postData, true);
    }

    // TODO finish the tax records stuff. I should've made another branch for this but lol

    /*
     * Get tax records for an alliance. Returns an array of all the records
     *
     * @param int $numRecords How many records should we return
     * @return array
     */
    /*public function getTaxRecords(int $numRecords) : array
    {
        $taxes = []; // Setup array that we'll return

        $html = $this->getTaxHTML($numRecords);

        $dom = new Dom();
        $dom->load($html);

        $maxRow = $numRecords + 2; // So we know how many rows to go up to in the taxes, add two

        for ($row = 2; $row < $maxRow; $row++)
        {
            // Setup/reset this array
            $record = [
                "timestamp" => "",
                "nID" => 0,
                "money" => 0,
                "food" => 0,
                "coal" => 0,
                "oil" => 0,
                "uranium" => 0,
                "iron" => 0,
                "bauxite" => 0,
                "gasoline" => 0,
                "munitions" => 0,
                "steel" => 0,
                "aluminum" => 0,
            ];

            // Get the timestamp and nation ID
            $record["timestamp"] = $html->find(".nationtable table tr:nth-child($row) td:nth-child(2)")->text;

            array_push($taxes, $record);
        }

        return $taxes;
    }*/

    /*
     * Get the HTML for taxes
     *
     * @param int $numRecords
     */
    /*protected function getTaxHTML(int $numRecords)
    {
        return $this->client->sendPOST("https://politicsandwar.com/alliance/id={$this->aID}&display=bank", [
            "maximum" => $numRecords,
            "minimum" => 0,
            "search" => "Go"
        ]);
    }*/
}
