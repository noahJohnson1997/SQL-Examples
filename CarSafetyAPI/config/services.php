<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/13/2021
 *   File: services.php
 *   Description:
 */

use SafeCar\Controllers\CarsController;
use SafeCar\Controllers\ModelssController;
use SafeCar\Controllers\SafetyController;
use SafeCar\Controllers\FeaturesController;
use SafeCar\Controllers\UserController;

$container['Cars']= function($c){
    return new CarsController();
};

$container['Modelss'] = function($c) {
    return new ModelssController();
};

$container['Safety'] = function($c) {
    return new SafetyController();
};

$container['Features'] = function($c) {
    return new FeaturesController();
};
$container['Users'] = function($c) {
    return new UserController();
};