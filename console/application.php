<?php

namespace console;

use Dotenv\Dotenv;
use Scheduler\Scenario;

date_default_timezone_set('UTC');
require_once(__DIR__ . '/../vendor/autoload.php');

//load configuration
$dotEnv = new Dotenv(__DIR__ . '/..');
$dotEnv->load();

$scenario = new Scenario();
$scenario->run();