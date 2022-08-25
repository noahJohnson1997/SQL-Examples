<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/20/2021
 *   File: Validator.php
 *   Description:
 */

namespace SafeCar\Validation;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator {
    private static $errors = [];

    // A generic validation method. it returns true on success or false on failure.
    public static function validate($request, array $rules) {
        foreach ($rules as $field => $rule) {
            //Retrieve parameters from URL or the request body
            $param = $request->getAttribute($field) ?? $request->getParam($field);
            try{
                $rule->setName(ucfirst($field))->assert($param);
            } catch (NestedValidationException $ex) {
                self::$errors[$field] = $ex->getMessage();
            }
        }

        return empty(self::$errors);
    }

    //Validate attributes of a Cars object.
    public static function validateCars($request) {
        //Define all the validation rules
        $rules = [
            'carModelID' => v::notEmpty(),
            'carSafetyRating' => v::notEmpty(),
            'carSafetyFeatures' => v::notEmpty()
        ];

        return self::validate($request, $rules);
    }

    // Validate attributes of a Users model. Do not include fields having default values (id, role, etc.)
    public function validateUser($request) {
        $rules = [
//            'name' => v::alnum(' '),
//            'email' => v::email(),
//            'username' => v::notEmpty(),
//            'password' => v::notEmpty()
        ];

        return self::validate($request, $rules);
    }

    public function validateFeature($request) {
        $rules = [
//            'class' => v::alnum(' '),
//            'description' => v::alnum(' '),
//            'bonus' => v::number(),
//            'carSafetyFeatures' => v::alnum()
        ];

        return self::validate($request, $rules);
    }

    //Return the errors in an array
    public static function getErrors() {
        return self::$errors;
    }


}