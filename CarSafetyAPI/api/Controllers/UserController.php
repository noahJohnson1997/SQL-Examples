<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/27/2021
 *   File: UserController.php
 *   Description: The user controller class
 */

namespace SafeCar\Controllers;

use SafeCar\Validation\Validator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SafeCar\Models\Users;
use SafeCar\Models\Token;

class UserController{

    //List users. The url may contain querystring parameters for login, authenticate with JWT or bearer token...
    public function index(Request $request, Response $response, array $args){
        $results = Users::getUsers();
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    //View a specific user by its id
    public function view(Request $request, Response $response, array $args){
        $id = $request->getAttribute('id');
        $results = Users::getUserById($id);

        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    //create a new user
    public function create(Request $request, Response $response, array $args){
        // Validate the request
        $validation = Validator::validateUser($request);

        // If validation failed
        if (!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        // Validation has passed; Proceed to create the professor
        $user = Users::createUser($request);
        $results = [
            'status' => 'user created',
            'data' => $user
        ];
        return $response->withJson($results, 201, JSON_PRETTY_PRINT);
    }

    // Update a user
    public function update(Request $request, Response $response, array $args)
    {
        // Validate the request
        $validation = Validator::validateUser($request);

        // If validation failed
        if (!$validation) {
            $results['status'] = "Validation failed";
            $results['errors'] = Validator::getErrors();
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        $user = Users::updateUser($request);
        $results = [
            'status' => 'user updated',
            'data' => $user
        ];
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    // Delete a user
    public function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        Users::deleteUser($id);
        $results = [
            'status' => 'User deleted',
        ];
        return $response->withJson($results, 200);
    }

    //Validate a user with username and password. It returns a Bearer token on success or error on failure.
    public function authBearer(Request $request, Response $response){
        //retrieve username and password from the request body
        $params = $request->getParsedBody();
        $username = $params['username'];
        $password = $params['password'];

        //Verify username and password
        $user = Users::authenticateUser($username, $password);

        if(!$user) {
            return $response->withJson(['status' => 'Login Failed'], 401, JSON_PRETTY_PRINT);
        }

        //Username and password are valid
        $token = Token::generateBearer($user->id);
        $results = ['status' => 'Login Successful', 'Token' => $token];

        return $response->withJson($results, 200, JSON_PRETTY_PRINT);

    }

    //Validate a user with username and password. It returns a JWT token on success
    public function authJWT(Request $request, Response $response){
        //Retrieve the username and password
        $params = $request->getParsedBody();
        $username = $params['username'];
        $password = $params['password'];

        //Verify username and password
        $user = Users::authenticateUser($username, $password);

        //if user invalid, return error
        if(!$user) {
            return $response->withJson(['status' => 'Login Failed'], 401, JSON_PRETTY_PRINT);
        }

        //username and password are valid
        $jwt = Users::generateJWT($user->id);
        $results = [
            'status' => 'Login successful',
            'jwt' => $jwt,
            'name' => $user->name,
            'role' => $user->role
        ];

        //return the results
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
}