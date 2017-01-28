<?php

namespace Yosodog\PWTools\API;

use Yosodog\PWTools\Client;

class Wars
{
    /**
     * Holds the JSON returned from the API.
     *
     * @var \stdClass
     */
    public $json;

    /**
     * Wars constructor.
     *
     * If requesting more than 2000 wars, it will only return like 200 or something
     *
     * @param int $wars
     */
    public function __construct(int $wars = 100)
    {
        $client = new Client();

        $this->json = \json_decode($client->getPage("http://politicsandwar.com/api/wars/{$wars}"));
    }

    public function getAllianceDefensiveWars(string $allianceName) : array
    {
        return $this->getAllianceWars($allianceName, 'defensive');
    }

    public function getAllianceOffensiveWars(string $allianceName) : array
    {
        return $this->getAllianceWars($allianceName, 'offensive');
    }

    protected function getAllianceWars(string $allianceName, string $type) : array
    {
        $wars = [];

        // So we can make this dynamic, check if we're looking for offensive or defensive wars
        if ($type == 'offensive')
            $var = 'attackingAA';
        elseif ($type == 'defensive')
            $var = 'defenderAA';

        foreach ($this->json->wars as $war)
        {
            if ($war->{$var} != $allianceName) // If the defender is not in the given alliance
                continue;

            // If they are in the defending alliance, push the war to the array
            array_push($wars, $war);
        }

        return $wars;
    }

    protected function getWarsByAlliance(string $allianceName, string $type)
    {
        $wars = [];

        // So we can make this dynamic, check if we're looking for offensive or defensive wars
        $var = $this->determineOffensiveOrDefensive($type);

        foreach ($this->json->wars as $war)
        {
            if ($war->{$var} != $allianceName) // If the defender is not in the given alliance
                continue;

            // If they are in the defending alliance, push the war to the array
            array_push($wars, $war);
        }

        return $wars;
    }

    protected function determineOffensiveOrDefensive($type) : string
    {
        switch ($type)
        {
            case 'offensive':
                $var = 'attackingAA';
                break;
            case 'defensive':
                $var = 'defendingAA';
                break;
            default:
                throw new \Exception('$type must be either offensive or defensive');
        }

        return $var;
    }
}
