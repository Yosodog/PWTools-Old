<?php

namespace Yosodog\PWTools\API;

use Yosodog\PWTools\Client;

class Alliance
{
    /**
     * Contains all of the leader nation IDs.
     *
     * @var array
     */
    public $leaderIDs = [];

    /**
     * The Alliance ID.
     *
     * @var int
     */
    public $aID;

    /**
     * The alliance name.
     *
     * @var string
     */
    public $name;

    /**
     * Surprise! It's the alliance's acronym.
     *
     * @var string
     */
    public $acronym;

    /**
     * The alliance's score.
     *
     * @var float
     */
    public $score;

    /**
     * The alliance's color.
     *
     * @var string
     */
    public $color;

    /**
     * How many members are in the alliance.
     *
     * For SOME REASON this seems like it includes vacation mode members
     * Maybe in the future I'll make it just subtract from vModeMembers so it'll be accurate
     *
     * @var int
     */
    public $members;

    /**
     * How many members are in vacation mode.
     *
     * @var int
     */
    public $vModeMembers;

    /**
     * If the alliance is accepting members or not.
     *
     * @var bool
     */
    public $acceptingMembers;

    /**
     * How many applicants the alliance has.
     *
     * @var int
     */
    public $applicants;

    /**
     * The URL to the alliance's flag.
     *
     * @var string
     */
    public $flagURL;

    /**
     * The URL to the alliance's forum.
     *
     * @var string
     */
    public $forumURL;

    /**
     * The alliance's IRC channel. The # is not included.
     *
     * @var string
     */
    public $irc;

    /**
     * The alliance's GDP.
     *
     * @var float
     */
    public $gdp;

    /**
     * How many cities the alliance has.
     *
     * @var int
     */
    public $cities;

    /**
     * How many soldiers the alliance has.
     *
     * @var int
     */
    public $soldiers;

    /**
     * How many tanks the alliance has.
     *
     * @var int
     */
    public $tanks;

    /**
     * How many aircraft the alliance has.
     *
     * @var int
     */
    public $aircraft;

    /**
     * How many ships the alliance has.
     *
     * @var int
     */
    public $ships;

    /**
     * How many missiles the alliance has.
     *
     * @var int
     */
    public $missiles;

    /**
     * How many nukes the alliance has.
     *
     * @var int
     */
    public $nukes;

    /**
     * How many treasures the alliance has.
     *
     * @var int
     */
    public $treasures;

    /**
     * Stores all of the alliance's Nation IDs.
     *
     * Run getNationIDs() to fill this array
     *
     * @var array
     */
    public $nationIDs = [];

    /**
     * Alliance constructor.
     *
     * @throws \Exception
     * @param int $aID
     */
    public function __construct(int $aID)
    {
        $client = new Client();

        $json = \json_decode($client->getPage("https://politicsandwar.com/api/alliance/id={$aID}"));

        if (isset($json->error)) // Throw an exception if the API returns an error
            throw new \Exception($json->error);
        // Set everything to everything
        foreach ($json->leaderids as $id)
            array_push($this->leaderIDs, intval($id));
        $this->aID = intval($json->allianceid);
        $this->name = $json->name;
        $this->acronym = $json->acronym;
        $this->score = floatval($json->score);
        $this->color = $json->color;
        $this->members = $json->members;
        $this->vModeMembers = $json->vmodemembers;
        $this->acceptingMembers = boolval($json->{'accepting members'});
        $this->applicants = $json->applicants;
        $this->flagURL = $json->flagurl;
        $this->forumURL = $json->forumurl;
        $this->irc = $json->irc;
        $this->gdp = $json->gdp;
        $this->cities = $json->cities;
        $this->soldiers = $json->soldiers;
        $this->tanks = $json->tanks;
        $this->aircraft = $json->aircraft;
        $this->ships = $json->ships;
        $this->missiles = $json->missiles;
        $this->nukes = $json->nukes;
        $this->treasures = $json->treasures;
    }

    /**
     * Grabs all of the nation IDs in this alliance.
     */
    public function getNationIDs()
    {
        $this->nationIDs = Nations::getAllianceNationIDs($this->aID);
    }
}
