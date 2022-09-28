<?php
declare(strict_types=1);

use SlomkaPro\Loadbalancer\BalanceStrategy\RoundRobinStrategy;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/simulation.php';

$strategy = new RoundRobinStrategy();

$simulation = new Simulation(5, 30);
$simulation->simulation($strategy);
