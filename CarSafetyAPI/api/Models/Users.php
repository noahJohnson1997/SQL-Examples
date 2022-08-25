<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/27/2021
 *   File: Users.php
 *   Description: The users class
 */

namespace SafeCar\Models;

use Illuminate\Database\Eloquent\Model;
use Firebase\JWT\JWT;

class Users extends Model{

    //JWT secret
    const JWT_KEY = 'SafeCar-api-v2$';

    //The lifetime of the JWT token: seconds
    const JWT_EXPIRE = 3600;

    //the table associated with this model. 'users' is the default name...
    protected $table = 'users';

    //the primary key of the table. 'id' is the default name...
    protected $primaryKey = 'id';

    //Is the pk an incrementing integer value? 'true' as default value...
    public $incrementing = true;

    //The data type of the pk. 'int' is the default value...
    protected $keyType = 'int';

    //do the created_at and updated_at columns exist in the table? 'true' is the default value...
    public $timestamps = true;

    //List all users
    public static function getUsers(){
        $users = self::all();
        return $users;
    }

    //View a specific user
    public static function getUserById(string $id){
        $user = self::findOrFail($id);
        return $user;
    }

    //Create a new Users
    public static function createUser($request){

        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        // Create a new Users instance
        $user = new Users();

        // Set the user's attributes
        foreach ($params as $field => $value) {

            // Need to hash password
            if ($field == 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }

            // Skip role. It defaults to 2.
            if ($field == 'role') {
                continue;
            }

            $user->$field = $value;
        }

        // Insert the user into the database
        $user->save();
        return $user;
    }

    // Update a user
    public static function updateUser($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        //Retrieve the user's id from url and then the user from the database
        $id = $request->getAttribute('id');
        $user = self::findOrFail($id);

        // Update attributes of the user
        $user->name = $params['name'];
        $user->email = $params['email'];
        $user->username = $params['username'];
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT);

        // Update the user
        $user->save();
        return $user;
    }

    // Delete a user
    public static function deleteUser($id)
    {
        $user = self::findOrFail($id);
        return ($user->delete());
    }

    /********** USER AUTHENTICATION AND AUTHORIZATION METHODS ***********/

    //authenticate user by user and pass
    public static function authenticateUser($username, $password){
        //retrieve records from user table
        $user = self::where('username', $username)->first();
        if(!$user){
            return false;
        }

        //verify password...
        return password_verify($password, $user->password) ? $user : false;
    }


    /********** JWT Authentication ***********/

    public static function generateJWT($id){
        //Data for the JWT payload
        $user = self::find($id);

        if(!$user){
            return false;
        }

        $key = self::JWT_KEY;
        $expiration = time() + self::JWT_EXPIRE;
        $issuer = 'safecar.com';

        $token = [
            'iss' => $issuer,
            'exp' => $expiration,
            'isa' => time(),
            'data' => [
                'uid' => $id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ];

        //Generate and return the token
        return JWT::encode(
            $token, //data to be encoded in the JWT
            $key, //the signing key
            'HS256' //algorithm used to sign the token; defaults to HS256
        );
    }

    //Validate a JWT token
    public static function validateJWT($token){
        $decoded = JWT::decode($token, self::JWT_KEY, array('HS256'));
        return $decoded;
    }
}