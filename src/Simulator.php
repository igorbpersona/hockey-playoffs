<?php
/**
 * @category  O2Web
 * @package   HockeyPlayoffs
 * @version   1.0.0
 * @author    Igor Persona <igorbpersona@gmail.com>
 */
declare(strict_types=1);

namespace src;

use Exception;

/**
 * Class Simulator
 * @package src
 */
class Simulator
{
    const DIVISIONS = ["East", "West"];
    const TEAMS = ["A", "B", "C", "D", "E", "F", "G", "H"];
    const MAX_NUMBER_OF_MATCHES = 7;

    /**
     * @var League
     */
    protected League $league;

    /**
     * Simulator constructor.
     * @param League|null $league
     */
    public function __construct(League $league = null)
    {
        $this->league = $league ?? new League();
    }

    /**
     * @return League
     */
    public function getLeague() : League
    {
        return $this->league;
    }

    private function init() : void {
        try {
            $teams = [];
            foreach (self::TEAMS as $team) {
                $teams[] = new Team($team);
            }
            $divisions = [];
            foreach (self::DIVISIONS as $division) {
                shuffle($teams);
                $divisions[] = new Division($division, $teams);
            }
            $this->getLeague()->setDivisions($divisions);
        } catch (Exception $e) {
            echo "Failed to initialize Simulator" . PHP_EOL;
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * @return Team
     */
    public function simulate() : Team
    {
        $this->init();
        $finals = [];
        $finalDivisions = [];
        foreach ($this->league->getDivisions() as $division) {
            $finals[] = $this->playDivision($division);
            $finalDivisions[] = $division->getName();
        }
        $championIndex = $this->playFinals($finals, $finalDivisions);
        return $finals[$championIndex];
    }

    /**
     * @param Team[] $finalists
     * @param string[] $divisions
     * @return int
     */
    public function playFinals(array $finalists, array $divisions) : int
    {
        $winCount = [0, 0];
        for ($i = 0; $i <= self::MAX_NUMBER_OF_MATCHES; $i++) {
            $winnerIndex = $this->playMatch($finalists[0], $finalists[1]);
            $winCount[$winnerIndex]++;
            if ($winCount[$winnerIndex] === 4) {
                echo sprintf(
                    "Final %s %s vs %s %s - Winner: %s %s (%d/%d)\n",
                    $divisions[0],
                    $finalists[0]->getName(),
                    $divisions[1],
                    $finalists[1]->getName(),
                    $divisions[$winnerIndex],
                    $finalists[$winnerIndex]->getName(),
                    $winCount[0],
                    $winCount[1],
                );
                return $winnerIndex;
            }
        }
    }

    /**
     * @param Division $division
     * @return Team
     */
    public function playDivision(Division $division) : Team
    {
        echo sprintf("%s Division:\n", $division->getName());
        $teamsToPlay = $division->getTeams();
        $roundsCount = 0;
        while (count($teamsToPlay) > 1) {
            echo sprintf("Round # %d:\n", $roundsCount);
            $teamsToPlay = $this->playRound($teamsToPlay);
            $roundsCount++;
        }
        echo "----------------------\n";
        return $teamsToPlay[0];
    }

    /**
     * @param Team[] $teamsToPlay
     */
    public function playRound(array $teamsToPlay) : array
    {
        $winners = [];
        while (count($teamsToPlay) > 0) {
            $winCount = [0, 0];
            $winner = null;
            for ($i = 0; $i <= self::MAX_NUMBER_OF_MATCHES; $i++) {
                $winnerIndex = $this->playMatch($teamsToPlay[0], $teamsToPlay[1]);
                $winCount[$winnerIndex]++;
                if ($winCount[$winnerIndex] === 4) {
                    $winner = $teamsToPlay[$winnerIndex];
                    echo sprintf(
                        "Serie %s vs %s - Winner: %s (%d/%d)\n",
                        $teamsToPlay[0]->getName(),
                        $teamsToPlay[1]->getName(),
                        $teamsToPlay[$winnerIndex]->getName(),
                        $winCount[0],
                        $winCount[1]
                    );
                    $teamsToPlay = array_slice($teamsToPlay, 2);
                    break;
                }
            }
            $winners[] = $winner;
        }
        return $winners;
    }

    /**
     * @param Team $team0
     * @param Team $team1
     * @return int
     */
    public function playMatch(Team $team0, Team $team1) : int
    {
        $team0MaxValue = $this->getTeamMaxValue($team0, $team1);
        $winningNumber = $this->getWinningNumber();
        /*echo sprintf(
            "%s: 0 - %f\n%s: %f - 1\nWinningNumber: %f\n",
            $team0->getName(),
            $team0MaxValue,
            $team1->getName(),
            $team0MaxValue + 0.01,
            $winningNumber
        );*/
        if ($team0MaxValue <= $winningNumber) {
            return 0;
        }
        return 1;
    }

    /**
     * @param Team $team0
     * @param Team $team1
     * @return float
     */
    public function getTeamMaxValue(Team $team0, Team $team1) : float
    {
        $oddsTeam0 = $team0->getOdds();
        $oddsTeam1 = $team1->getOdds();
        $coef = $oddsTeam0 - $oddsTeam1;
        return 0.5 + (0.5 * $coef);
    }

    /**
     * @return float
     */
    public function getWinningNumber() : float
    {
        return mt_rand(0, 100) / 100;
    }
}
