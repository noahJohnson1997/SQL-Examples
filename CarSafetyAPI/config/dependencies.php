<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/13/2021
 *   File: dependencies.php
 *   Description:
 */

// Get the Container instance
$container = $app->getContainer();

// Overwrite the default notFoundHandler to return a json
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) {
        return $response->withJson(array("status" => "Request not found"), 500, JSON_PRETTY_PRINT);
    };
};

// Overwrite the default PHP exception handler
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) {
        return $response->withJson(array("status" => $exception->getMessage()), 500, JSON_PRETTY_PRINT);
    };
};

// Overwrite the default PHP 7 error handler
$container['phpErrorHandler'] = function ($c) {
    return $c['errorHandler'];
};


// Configure Eloquent
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Add Eloquent capsule to the DIC.
// This function gets called only when the capsule is actually used, e.g. $this->db
$container['db'] = function() use($capsule) {
    return $capsule;
};