<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/19/2021
 *   File: SafetyController.php
 *   Description:
 */

namespace SafeCar\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SafeCar\Models\Safety;

class SafetyController {
    //list all Safety
    public function index(Request $request, Response $response, array $args){
        $results = Safety::getSafety();
        return $response->withJson($results, 200,JSON_PRETTY_PRINT);
    }

//    view a specific safety
    public function view(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $results = Safety::getSafetyById($id);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
    public function viewCars(Request $request, Response $response, array $args){
        $number = $args['id'];
        $results = Safety::getCarbySafety($number);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

}
