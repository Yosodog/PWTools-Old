<?php

namespace Yosodog\PWTools\API;

use Yosodog\PWTools\Client;

class War
{
    /**
     * Has the war ended?
     *
     * @var bool
     */
    public $warEnded;

    /**
     * Date/time of the war declaration.
     *
     * @var string
     */
    public $date;

    /**
     * Aggressor's nation ID.
     *
     * @var int
     */
    public $aggressorID;

    /**
     * Defender's nation ID.
     *
     * @var int
     */
    public $defenderID;

    /**
     * Alliance name of the aggressor.
     *
     * @var string
     */
    public $aggressorAlliance;

    /**
     * Alliance name of the defender.
     *
     * @var string
     */
    public $defenderAlliance;

    /**
     * Is the defender an applicant?
     *
     * @var bool
     */
    public $defenderApplicant;

    /**
     * Is the aggressor offering peace?
     *
     * @var bool
     */
    public $aggressorOfferingPeace;

    /**
     * The war reason.
     *
     * @var string
     */
    public $warReason;

    /**
     * Which nation ID has ground control. 0 if no one has ground control.
     *
     * @var int
     */
    public $groundControl;

    /**
     * Which nation ID has air superiority. 0 if no one has air superiority.
     *
     * @var int
     */
    public $airSuperiority;

    /**
     * Which nation ID has a blockade. 0 if no one is blockaded.
     *
     * @var int
     */
    public $blockade;

    /**
     * How many military action points the aggressor has.
     *
     * @var int
     */
    public $aggressorMAPs;

    /**
     * How many military action points the defender has.
     *
     * @var int
     */
    public $defenderMAPs;

    /**
     * What the aggressor's resistance is at.
     *
     * @var int
     */
    public $aggressorResistance;

    /**
     * What the defender's resistance is at.
     *
     * @var int
     */
    public $defenderResistance;

    /**
     * Is the aggressor fortified?
     *
     * @var bool
     */
    public $aggressorFortified;

    /**
     * Is the defender fortified?
     *
     * @var bool
     */
    public $defenderFortified;

    /**
     * How many turns are left in the war.
     *
     * @var int
     */
    public $turnsLeft;

    /**
     * War constructor.
     *
     * @param int $warID
     * @throws \Exception
     */
    public function __construct(int $warID)
    {
        $client = new Client();

        $json = \json_decode($client->getPage("https://politicsandwar.com/api/war/{$warID}"));

        if (! $json->success)
            throw new \Exception($json->general_message);
        $this->warEnded = $json->war[0]->war_ended;
        $this->date = $json->war[0]->date;
        $this->aggressorID = intval($json->war[0]->aggressor_id);
        $this->defenderID = intval($json->war[0]->defender_id);
        $this->aggressorAlliance = $json->war[0]->aggressor_alliance_name;
        $this->defenderAlliance = $json->war[0]->defender_alliance_name;
        $this->defenderApplicant = $json->war[0]->defender_is_applicant;
        $this->aggressorOfferingPeace = $json->war[0]->aggressor_offering_peace;
        $this->warReason = $json->war[0]->war_reason;
        $this->groundControl = intval($json->war[0]->ground_control);
        $this->airSuperiority = intval($json->war[0]->air_superiority);
        $this->blockade = intval($json->war[0]->blockade);
        $this->aggressorMAPs = intval($json->war[0]->aggressor_military_action_points);
        $this->defenderMAPs = intval($json->war[0]->defender_military_action_points);
        $this->aggressorResistance = intval($json->war[0]->aggressor_resistance);
        $this->defenderResistance = intval($json->war[0]->defender_resistance);
        $this->defenderFortified = $json->war[0]->defender_is_fortified;
        $this->aggressorFortified = $json->war[0]->aggressor_is_fortified;
        $this->turnsLeft = $json->war[0]->turns_left;
    }
}
