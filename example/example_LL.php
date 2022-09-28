<?php
declare(strict_types=1);

use SlomkaPro\Loadbalancer\BalanceStrategy\LoadLimitStrategy;
use SlomkaPro\Loadbalancer\LoadBalancer;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/simulation.php';

$strategy = new LoadLimitStrategy(0.75);

$simulation = new Simulation(5, 30);
$simulation->simulation($strategy);

