<?php
/**
 *   Author: Noah johnson
 *   Date: 7/27/2021
 *   File: MyAuthenticator.php
 *   Description:
 */

namespace SafeCar\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SafeCar\Models\Users;

class MyAuthenticator{
    /*
    * Use the __invoke method so the object can be used as a callable.
    * This method gets called automatically when the object is treated as a callable.
    */
    public function __invoke(Request $request, Response $response, $next){

        //Username and Password are stored in a header called "MyCollegeAPI-Authorization". Value of the header
        //is formatted as username:password
        if(!$request->hasHeader('SafeCar-Authorization')){
            $results = ['status' => 'Authorization header not found'];
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        //Retrieve the header and then the username and password
        $auth = $request->getHeader('SafeCar-Authorization');
        list($username, $password) = explode(':', $auth[0]);

        //Validate the Username and password
        if(!Users::authenticateUser($username, $password)){
            $results = ['status' => 'Authentication failed.'];
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        //A user has been authenticated
        $response = $next($request, $response);
        return $response;
    }
}