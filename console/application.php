<?php

namespace console;

use Dotenv\Dotenv;
use Scheduler\Scenario;

require_once(__DIR__ . '/../vendor/autoload.php');

//load configuration
$dotEnv = new Dotenv(__DIR__ . '/..');
$dotEnv->load();

$scenario = new Scenario();
$scenario->run();