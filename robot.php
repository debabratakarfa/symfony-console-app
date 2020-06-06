#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use IntuitiveApp\Command\RobotCommand;

$application = new Application('Intuitive Command App', '0.0.1');

// Registering Intuitive Robot Command
$application->add(new RobotCommand());

$application->run();
