<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/27/2021
 *   File: BearerAuthenticator.php
 *   Description:
 */

namespace SafeCar\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SafeCar\Models\Token;

class BearerAuthenticator{
    public function __invoke(Request $request, Response $response, $next){
        //if the header named "authorization" does not exist, return an error..
        if(!$request->hasHeader('Authorization')){
            $results = ['status' => 'Authorization header not found'];
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        //Retrieve the header and the token
        $auth = $request->getHeader('Authorization');
        $token = substr($auth[0], strpos($auth[0], ' ') + 1);

        //validate the token
        if(!Token::validateBearer($token)){
            return $response->withJson(['status'=>'authentication failed'], 401, JSON_PRETTY_PRINT);
        }

        //A user has been authenticated
        $response = $next($request, $response);
        return $response;
    }
}