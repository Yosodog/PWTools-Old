<?php

namespace Yosodog\PWTools\API;

use PHPHtmlParser\Dom;
use Yosodog\PWTools\Client;

class City
{
    /**
     * @var int
     */
    public $cID;

    /**
     * @var string
     */
    public $url;

    /**
     * @var int
     */
    public $nID;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $leader;

    /**
     * @var string
     */
    public $continent;

    /**
     * @var string
     */
    public $founded;

    /**
     * @var int
     */
    public $age;

    /**
     * @var bool
     */
    public $powered;

    /**
     * @var float
     */
    public $infra;

    /**
     * @var float
     */
    public $land;

    /**
     * @var float
     */
    public $population;

    /**
     * @var float
     */
    public $popDensity;

    /**
     * @var float
     */
    public $crime;

    /**
     * @var float
     */
    public $disease;

    /**
     * @var float
     */
    public $commerce;

    /**
     * @var float
     */
    public $avgIncome;

    /**
     * @var int
     */
    public $pollution;

    /**
     * @var int
     */
    public $nuclearPollution;

    /**
     * @var int
     */
    public $basePop;

    /**
     * @var float
     */
    public $basePopDensity;

    /**
     * @var float
     */
    public $minimumWage;

    /**
     * @var float
     */
    public $popLostDisease;

    /**
     * @var float
     */
    public $popLostCrime;

    /**
     * @var int
     */
    public $coalPower;

    /**
     * @var int
     */
    public $oilPower;

    /**
     * @var int
     */
    public $nuclearPower;

    /**
     * @var int
     */
    public $windPower;

    /**
     * @var int
     */
    public $coalMines;

    /**
     * @var int
     */
    public $oilWells;

    /**
     * @var int
     */
    public $ironMines;

    /**
     * @var int
     */
    public $bauxiteMines;

    /**
     * @var int
     */
    public $leadMines;

    /**
     * @var int
     */
    public $uraniumMines;

    /**
     * @var int
     */
    public $farms;

    /**
     * @var int
     */
    public $gasRefineries;

    /**
     * @var int
     */
    public $steelMills;

    /**
     * @var int
     */
    public $aluminumFactories;

    /**
     * @var int
     */
    public $munitionsFactories;

    /**
     * @var int
     */
    public $policeStations;

    /**
     * @var int
     */
    public $hospitals;

    /**
     * @var int
     */
    public $recyclingCenters;

    /**
     * @var int
     */
    public $subways;

    /**
     * @var int
     */
    public $supermarkets;

    /**
     * @var int
     */
    public $banks;

    /**
     * @var int
     */
    public $malls;

    /**
     * @var int
     */
    public $stadiums;

    /**
     * @var int
     */
    public $barracks;

    /**
     * @var int
     */
    public $factories;

    /**
     * @var int
     */
    public $hangars;

    /**
     * @var int
     */
    public $drydocks;

    /**
     * Holds the Client that we use to grab stuff.
     *
     * @var Client
     */
    protected $client;

    /**
     * How many improvements this city uses.
     *
     * @var int
     */
    protected $numImprovements;

    /**
     * How many improvement slots this city has.
     *
     * @var int
     */
    protected $totalImpSlots;

    public function __construct(int $cID)
    {
        $this->client = new Client();
        $json = \json_decode($this->client->getPage("https://politicsandwar.com/api/city/id={$cID}"));

        if (isset($json->error))
            throw new \Exception($json->error);
        $this->cID = intval($json->cityid);
        $this->url = $json->url;
        $this->nID = intval($json->nationid);
        $this->name = $json->name;
        $this->nation = $json->nation;
        $this->leader = $json->leader;
        $this->continent = $json->continent;
        $this->founded = $json->founded;
        $this->age = $json->age;
        $this->powered = $json->powered == 'Yes' ? true : false;
        $this->infra = floatval($json->infrastructure);
        $this->land = floatval($json->land);
        $this->population = $json->population;
        $this->popDensity = $json->popdensity;
        $this->crime = $json->crime;
        $this->disease = $json->disease;
        $this->commerce = $json->commerce;
        $this->avgIncome = $json->avgincome;
        $this->pollution = $json->pollution;
        $this->nuclearPollution = $json->nuclearpollution;
        $this->basePop = $json->basepop;
        $this->basePopDensity = $json->basepopdensity;
        $this->minimumWage = $json->minimumwage;
        $this->popLostDisease = $json->poplostdisease;
        $this->popLostCrime = $json->poplostcrime;
        $this->coalPower = $json->imp_coalpower;
        $this->oilPower = $json->imp_oilpower;
        $this->nuclearPower = $json->imp_nuclearpower;
        $this->windPower = $json->imp_windpower;
        $this->coalMines = $json->imp_coalmine;
        $this->oilWells = $json->imp_oilwell;
        $this->ironMines = $json->imp_ironmine;
        $this->bauxiteMines = $json->imp_bauxitemine;
        $this->leadMines = $json->imp_leadmine;
        $this->uraniumMines = $json->imp_uramine;
        $this->farms = $json->imp_farm;
        $this->gasRefineries = $json->imp_gasrefinery;
        $this->steelMills = $json->imp_steelmill;
        $this->aluminumFactories = $json->imp_aluminumrefinery;
        $this->munitionsFactories = $json->imp_munitionsfactory;
        $this->policeStations = $json->imp_policestation;
        $this->hospitals = $json->imp_hospital;
        $this->recyclingCenters = $json->imp_recyclingcenter;
        $this->subways = $json->imp_subway;
        $this->supermarkets = $json->imp_supermarket;
        $this->banks = $json->imp_bank;
        $this->malls = $json->imp_mall;
        $this->stadiums = $json->imp_stadium;
        $this->barracks = $json->imp_barracks;
        $this->factories = $json->imp_factory;
        $this->hangars = $json->imp_hangar;
        $this->drydocks = $json->imp_drydock;
    }

    /**
     * Gets the number of improvements in the city.
     *
     * If it isn't already set, it will calculate it and set it
     *
     * @return int
     */
    public function getNumImprovements() : int
    {
        if (! isset($this->numImprovements))
            $this->setNumImprovements();

        return $this->numImprovements;
    }

    /**
     * Counts how many improvement slots the city uses.
     *
     * Returns an int and also stores the value as numImprovements
     */
    protected function setNumImprovements()
    {
        $slots = 0;
        $slots += $this->coalPower;
        $slots += $this->oilPower;
        $slots += $this->nuclearPower;
        $slots += $this->windPower;
        $slots += $this->coalMines;
        $slots += $this->ironMines;
        $slots += $this->oilWells;
        $slots += $this->bauxiteMines;
        $slots += $this->leadMines;
        $slots += $this->uraniumMines;
        $slots += $this->farms;
        $slots += $this->oilWells;
        $slots += $this->steelMills;
        $slots += $this->aluminumFactories;
        $slots += $this->munitionsFactories;
        $slots += $this->policeStations;
        $slots += $this->hospitals;
        $slots += $this->recyclingCenters;
        $slots += $this->subways;
        $slots += $this->supermarkets;
        $slots += $this->banks;
        $slots += $this->malls;
        $slots += $this->stadiums;
        $slots += $this->barracks;
        $slots += $this->factories;
        $slots += $this->hangars;
        $slots += $this->drydocks;

        $this->numImprovements = $slots;
    }

    /**
     * Calculate and set the total improvement slots in the city.
     */
    protected function setTotalImpSlots()
    {
        $this->totalImpSlots = floor($this->infra / 50);
    }

    /**
     * Returns the total improvement slots. If it's not set, then it'll set it.
     *
     * @return int
     */
    public function getTotalImpSlots(): int
    {
        if (isset($this->totalImpSlots))
            $this->setTotalImpSlots();

        return $this->totalImpSlots;
    }

    /**
     * Buy an improvement. To get the improvement name, for now just look at the HTML.
     *
     * @param string $name
     * @param Client $client
     */
    public function buyImprovement(string $name, Client $client)
    {
        $this->client = $client;

        $this->modifyImprovement($name, 'buy');
    }

    /**
     * Sell an improvement. To get the improvement name, for now just look at the HTML.
     *
     * @param string $name
     * @param Client $client
     */
    public function sellImprovement(string $name, Client $client)
    {
        $this->client = $client;

        $this->modifyImprovement($name, 'sell');
    }

    /**
     * The method that actually buys or sells an improvement
     *
     * @param string $name
     * @param string $sellOrBuy
     * @throws \Exception
     */
    protected function modifyImprovement(string $name, string $sellOrBuy)
    {
        if (!$this->client->isLoggedIn())
            throw new \Exception('You must be logged in to do this action');

        $token = $this->getToken();

        $param = $sellOrBuy.$name; // Concat the improvement name with the sell/buy

        $this->client->sendPOST("https://politicsandwar.com/city/id={$this->cID}", [
            $param => $sellOrBuy === "buy" ? "+" : "-",
            "token" => $token,
        ]);
    }

    /**
     * Gets a CSRF token from the city page
     *
     * @return string
     * @throws \Exception
     */
    protected function getToken() : string
    {
        if (!$this->client->isLoggedIn())
            throw new \Exception('You must be logged in to do this action');

        $html = $this->client->getPage("https://politicsandwar.com/city/id={$this->cID}");

        $dom = new Dom();
        $dom->load($html);

        $token = $dom->find("input[name=token]");

        return $token->value;
    }

    /**
     * Use the in-game method to export to a JSON string
     *
     * @return string
     */
    public function export() : string
    {
        return $this->client->getPage("https://politicsandwar.com/city/improvements/export/id={$this->cID}");
    }

    /**
     * Import a city using the in-game import function
     *
     * The $json string needs to be in valid JSON format in order for the game to accept it.
     * I don't do any verification on the string at this time.
     *
     * @param string $json
     * @param Client $client
     * @throws \Exception
     */
    public function import(string $json, Client $client)
    {
        if (!$client->isLoggedIn())
            throw new \Exception("You must be logged in to do this action");

        $this->client = $client;

        $this->client->sendPOST("https://politicsandwar.com/city/improvements/import/id={$this->cID}", [
            "imp_import" => $json,
            "imp_import_execute" => "Execute Operation",
        ], true);
    }
}
