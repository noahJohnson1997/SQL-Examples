<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/19/2021
 *   File: FeaturesController.php
 *   Description:
 */

namespace SafeCar\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SafeCar\Models\Features;
use SafeCar\Validation\Validator;

class FeaturesController {
    //list all Features
    public function index(Request $request, Response $response, array $args){
        $params = $request->getQueryParams();
        $term = array_key_exists('q', $params) ? $params['q'] : null;

        if(!is_null($term)) {
            $results = Features::searchFeatures($term);
        } else {
            $results = Features::getFeatures();
        }
        return $response->withJson($results, 200,JSON_PRETTY_PRINT);
    }

//    view a specific Features
    public function view(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $results = Features::getFeaturesById($id);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    public function create(Request $request, Response $response, array $args){
        //validate the data
        $validation = Validator::validateFeature($request);

        if(!$validation){
            $results = [
                'status' => "Validation Failed",
                'errors' => Validator::getErrors()
            ];
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        //insert a new student to the db
        $feature = Features::createFeature($request);
        $results = [
            'status'=>"Feature Created",
            'data'=>$feature,
        ];
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);

    }

    public function update(Request $request, Response $response, array $args){
        //validate the request
        $validation = Validator::validateFeature($request);

        //if validation fails
        if(!$validation){
            $results['status'] = "Validation failed.";
            $results['errors'] = Validator::getErrors();
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        $feature = Features::updateFeature($request);
        $status = $feature ? "Feature has been updated" : "Feature cannot be updated";
        $statuscode = $feature ? 200 : 500;
        $results['status'] = $status;
        if($feature){
            $results['data'] = $feature;
        }
        return $response->withJson($results, $statuscode, JSON_PRETTY_PRINT);
    }

    public function delete(Request $request, Response $response, array $args){
        $feature = Features::deleteFeature($request);
        $status = $feature ? "Student has been deleted" : "Student cannot be deleted";
        $statuscode = $feature ? 200 : 500;
        $results = ['status'=>$status];
        return $response->withJson($results, $statuscode, JSON_PRETTY_PRINT);
    }

}