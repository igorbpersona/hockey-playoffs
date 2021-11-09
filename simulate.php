<?php
/**
 * @category  O2Web
 * @package   HockeyPlayoffs
 * @version   1.0.0
 * @author    Igor Persona <igorbpersona@gmail.com>
 */
require __DIR__.'/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use src\Simulator;

$simulator = new Simulator();
$champion = $simulator->simulate();