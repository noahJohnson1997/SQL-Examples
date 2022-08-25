<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/13/2021
 *   File: bootstrap.php
 *   Description:
 */

// Load system configuration settings
$config = require __DIR__ . '/config.php';

// Load composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Prepare app
$app = new \Slim\App(['settings' => $config]);

// Add dependencies to the Container
require __DIR__ . '/dependencies.php';

require __DIR__ . '/services.php';

// Create routes
require __DIR__ . '/routes.php';