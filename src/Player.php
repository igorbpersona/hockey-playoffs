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
 * Class Player
 * @package src
 */
class Player
{
    const MIN_SUCCESS_RATE = 0.15;
    const MAX_SUCCESS_RATE = 1;

    /**
     * @var float
     */
    protected float $successRate;

    /**
     * Player constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->assignRandomSuccessRate();
    }

    /**
     * @param float $rate
     * @throws Exception
     */
    public function setSuccessRate(float $rate)
    {
        if (!$this->isValidRate($rate)) {
            throw new Exception(
                sprintf("Rate must be between %f and %f", self::MIN_SUCCESS_RATE, self::MAX_SUCCESS_RATE)
            );
        }
        $this->successRate = $rate;
    }

    /**
     * @return float
     */
    public function getSuccessRate() : float
    {
        return $this->successRate;
    }

    /**
     * @throws Exception
     */
    public function assignRandomSuccessRate() : void
    {
        $this->setSuccessRate(
            mt_rand(
                intval(self::MIN_SUCCESS_RATE * 100),
                intval(self::MAX_SUCCESS_RATE * 100)
            ) / 100
        );
    }

    /**
     * @param float $rate
     * @return bool
     */
    protected function isValidRate(float $rate) : bool
    {
        return (self::MIN_SUCCESS_RATE <= $rate && self::MAX_SUCCESS_RATE >= $rate);
    }
}
