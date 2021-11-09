<?php
/**
 * @category  O2Web
 * @package   HockeyPlayoffs
 * @version   1.0.0
 * @author    Igor Persona <igorbpersona@gmail.com>
 */
declare(strict_types=1);

namespace src;

/**
 * Class Team
 * @package src
 */
class Team
{
    const DEFAULT_NUMBER_OF_PLAYERS = 21;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var Player[]
     */
    protected array $players;

    /**
     * Team constructor.
     * @param string $name
     * @param Player[] $players
     */
    public function __construct(string $name = '', array $players = [])
    {
        $this->setName($name);
        if (empty($players)) {
            for ($i = 0; $i <= self::DEFAULT_NUMBER_OF_PLAYERS; $i++) {
                $players[] = new Player();
            }
        }
        $this->setPlayers($players);
    }

    /**
     * @return Player[]
     */
    public function getPlayers() : array
    {
        return $this->players;
    }

    /**
     * @param Player[] $players
     */
    public function setPlayers(array $players)
    {
        $this->players = $players;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getOdds() : float
    {
        $successRates = [];
        foreach ($this->getPlayers() as $player) {
            $successRates[] = $player->getSuccessRate();
        }
        $countRates = count($successRates);
        if ($countRates === 0) {
            return 0;
        }
        return array_sum($successRates) / $countRates;
    }
}
