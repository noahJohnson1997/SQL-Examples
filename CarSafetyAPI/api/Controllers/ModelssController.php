<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/16/2021
 *   File: ModelsControllers.php
 *   Description:
 */

namespace SafeCar\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SafeCar\Models\Modelss;

class ModelssController {
    //list all Modelss
//    public function index(Request $request, Response $response, array $args){
//        $results = Modelss::getModelss();
//        return $response->withJson($results, 200,JSON_PRETTY_PRINT);
//    }

    public function index(Request $request, Response $response, array $args) {
        //Get querystring variables from ulr
        $params = $request->getQueryParams();
        $term = array_key_exists('q', $params) ? $params['q'] : null;

        if(!is_null($term)) {
            $results = Modelss::searchModels($term);
        } else {
            $results = Modelss::getModelss($request);
        }

        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

//    view a specific modelss
    public function view(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $results = Modelss::getModelssById($id);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }



}
