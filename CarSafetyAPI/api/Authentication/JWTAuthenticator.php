<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/27/2021
 *   File: JWTAuthenticator.php
 *   Description: the jwt authentication class
 */

namespace SafeCar\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SafeCar\Models\User;
use SafeCar\Models\Users;

class JWTAuthenticator {
    public function __invoke(Request $request, Response $response, $next){
        //if the header named "authorization" does not exist, return an error..
        if(!$request->hasHeader('Authorization')){
            $results = ['status' => 'Authorization header not found'];
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        //Retrieve the header and the token
        $auth = $request->getHeader('Authorization');
        $token = substr($auth[0], strpos($auth[0], ' ') + 1);

        //Validate the token
        if(!Users::validateJWT($token)){
            return $response->withJson(['status'=>'authentication failed'], 401, JSON_PRETTY_PRINT);
        }

        //A user has been authenticated
        $response = $next($request, $response);
        return $response;
    }

}