<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/13/2021
 *   File: routes.php
 *   Description:
 */

use SafeCar\Authentication\{
    MyAuthenticator,
    BasicAuthenticator,
    BearerAuthenticator,
    JWTAuthenticator
};

// Define app routes
$app->get('/', function ($request, $response, $args) {
    return $response->write('Welcome to SafeCar');
});

$app->get('/api/hello/{name}', function ($request, $response, $args) {
    return $response->write("Hello " . $args['name']);
});

//Route group
$app->group('/api/v1', function() {

    //The Cars group
    $this->group('/cars', function () {
        $this->get('', 'Cars:index');
        $this->get('/{id}', 'Cars:view');
        $this->post('', 'Cars:create');
        $this->put('/{id}', 'Cars:update');
        $this->delete('/{id}', 'Cars:delete');
        $this->get('/{id}/models', 'Cars:viewModel');
    });

    //The Models group
    $this->group('/modelss', function () {
        $this->get('', 'Modelss:index');
        $this->get('/{id}', 'Modelss:view');
    });

    //The Safety group
    $this->group('/safety', function () {
        $this->get('', 'Safety:index');
        $this->get('/{id}', 'Safety:view');
        $this->get('/{id}/cars', 'Safety:viewCars');
    });

    //The Features group
    $this->group('/features', function () {
        $this->get('', 'Features:index');
        $this->get('/{id}', 'Features:view');
        $this->post('', 'Features:create');
        $this->put('/{id}', 'Features:update');
        $this->delete('/{id}', 'Features:delete');
    });

//})->add(new MyAuthenticator()); //myauthenticator authentication
//})->add(new BasicAuthenticator()); //basic authentication
//})->add(new BearerAuthenticator()); //bearer authentication
})->add(new JWTAuthenticator()); //JWT Authenticator

// Users routes
$app->group('/api/v1/users', function () {
    $this->get('', 'Users:index');
    $this->get('/{id}', 'Users:view');
    $this->post('', 'Users:create');
    $this->put('/{id}', 'Users:update');
    $this->delete('/{id}', 'Users:delete');
    $this->post('/authBearer', 'Users:authBearer');
    $this->post('/authJWT', 'Users:authJWT');
});