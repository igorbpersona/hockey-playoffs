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
 * Class Division
 * @package src
 */
class Division
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var array
     */
    protected array $teams;


    /**
     * Division constructor.
     * @param string $name
     * @param Team[] $teams
     */
    public function __construct(string $name = "", array $teams = [])
    {
        $this->setTeams($teams);
        $this->setName($name);
    }

    /**
     * @return array
     */
    public function getTeams() : array
    {
        return $this->teams;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param Team[] $teams
     */
    public function setTeams(array $teams)
    {
        $this->teams = $teams;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
