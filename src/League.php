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
 * Class League
 * @package src
 */
class League
{
    /**
     * @var Division[]
     */
    protected array $divisions;

    /**
     * League constructor.
     * @param Division[] $divisions
     */
    public function __construct(array $divisions = [])
    {
        $this->setDivisions($divisions);
    }

    /**
     * @return Division[]
     */
    public function getDivisions() : array
    {
        return $this->divisions;
    }

    /**
     * @param Division[] $divisions
     */
    public function setDivisions(array $divisions) : void
    {
        $this->divisions = $divisions;
    }
}
