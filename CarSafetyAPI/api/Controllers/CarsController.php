<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/13/2021
 *   File: CarsController.php
 *   Description:
 */

namespace SafeCar\Controllers;

use SafeCar\Validation\Validator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SafeCar\Models\Cars;

class CarsController {
    //list all cars
    public function index(Request $request, Response $response, array $args){
        $results = Cars::getCars($request);
        return $response->withJson($results, 200,JSON_PRETTY_PRINT);
    }

//    view a specific cars
    public function view(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $results = Cars::getCarsById($id);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    //view classes by a professor
    public function viewModel(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Cars::getModelbyCar($id);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    public function create(Request $request, Response $response, array $args){
        //validate the data
        $validation = Validator::validateCars($request);

        if(!$validation){
            $results = [
                'status' => "Validation Failed",
                'errors' => Validator::getErrors()
            ];
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        //insert a new car to the db
        $car = Cars::createCar($request);
        $results = [
            'status'=>"Car Created",
            'data'=>$car,
        ];
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);

    }


    public function update(Request $request, Response $response, array $args){
        //validate the request
        $validation = Validator::validateCars($request);

        //if validation fails
        if(!$validation){
            $results['status'] = "Validation failed.";
            $results['errors'] = Validator::getErrors();
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        $car = Cars::updateCar($request);
        $status = $car ? "Car has been updated" : "Car cannot be updated";
        $statuscode = $car ? 200 : 500;
        $results['status'] = $status;
        if($car){
            $results['data'] = $car;
        }
        return $response->withJson($results, $statuscode, JSON_PRETTY_PRINT);
    }


    public function delete(Request $request, Response $response, array $args){
        $car = Cars::deleteCar($request);
        $status = $car ? "Car has been deleted" : "Car cannot be deleted";
        $statuscode = $car ? 200 : 500;
        $results = ['status'=>$status];
        return $response->withJson($results, $statuscode, JSON_PRETTY_PRINT);
    }


}
