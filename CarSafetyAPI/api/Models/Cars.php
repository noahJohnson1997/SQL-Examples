<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/13/2021
 *   File: Cars.php
 *   Description:
 */

namespace SafeCar\Models;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model{
    protected $table = 'cars';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = "int";

    public $timestamps = false;


    //sets the relation between models and cars...
    public function carModels() {
        return $this->belongsTo('SafeCar\Models\Modelss', 'carModelID');
    }

    //sets the relation between safety rating and cars...
    public function carSafety(){
        return $this->belongsTo('SafeCar\Models\Safety', 'carSafetyRating');
    }

    //sets the relation between safety features and cars...
    public function carFeatures(){
        return $this->belongsTo('SafeCar\Models\Features', 'carSafetyFeatures');
    }

    //    retrieve all models
    public static function getCars($request) {
        return self::all();
//        //code for pagination...
//        //get the total number of row count
//        $count = self::count();
//
//        //get querystring variables from url
//        $params = $request->getQueryParams();
//
//        //do limit and offset exist
//        $limit = array_key_exists('limit', $params) ?  (int)$params['limit'] : 10; //items per page...
//        $offset = array_key_exists('offset', $params) ? (int)$params['offest'] : 0; //offset of the first item...
//
//        //pagination
//        $links = self::getLinks($request, $limit, $offset);
//
//        //sorting
//        $sort_key_array = self::getSortKeys($request);
//
//        //query build
//        $query = self::with('carModels', 'carSafety', 'carFeatures');
//        $query = $query->skip($offset)->take($limit);
//
//        //sort the output by one or more columns
//        foreach ($sort_key_array as $column=>$direction){
//            $query->orderBy($column, $direction);
//        }
//
//        $cars = $query->get();
//
//        $results = [
//            'totalCount' => $count,
//            'limit' => $limit,
//            'offset' => $offset,
//            'links' => $links,
//            'sort' => $sort_key_array,
//            'data' => $cars
//        ];
//
//        return $results;
    }

    //View a specific professor by id
    public static function getCarsById(string $id) {
        $cars = self::findOrFail($id);
        $cars->load('carModels')->load('carSafety')->load('carFeatures');
        return $cars;
    }

    //view the model of a particular car
    //view all classes taught by a professor
    public static function getModelbyCar(string $id){
        $classes = self::findorFail($id)->carModels;
        return $classes;
    }

    // This function returns an array of links for pagination. The array includes links for the current, first, next, and last pages.
    private static function getLinks($request, $limit, $offset) {
        $count = self::count();

        // Get requet uri and parts
        $uri = $request->getUri();
        $base_url = $uri->getBaseUrl();
        $path = $uri->getPath();

        // Construct links for pagination
        $links = array();
        $links[] = ['rel' => 'self', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=$offset"];
        $links[] = ['rel' => 'first', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=0"];
        if ($offset - $limit >= 0) {
            $links[] = ['rel' => 'prev', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=" . ($offset - $limit)];
        }
        if ($offset + $limit < $count) {
            $links[] = ['rel' => 'next', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=" . ($offset + $limit)];
        }
        $links[] = ['rel' => 'last', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=" . $limit * (ceil($count / $limit) - 1)];

        return $links;
    }
    /*
 * Sort keys are optionally enclosed in [ ], separated with commas;
 * Sort directions can be optionally appended to each sort key, separated by :.
 * Sort directions can be 'asc' or 'desc' and defaults to 'asc'.
 * Examples: sort=[number:asc,title:desc], sort=[number, title:desc]
 * This function retrieves sorting keys from uri and returns an array.
*/
    private static function getSortKeys($request) {
        $sort_key_array = array();

        // Get querystring variables from url
        $params = $request->getQueryParams();

        if (array_key_exists('sort', $params)) {
            $sort = preg_replace('/^\[|\]$|\s+/', '', $params['sort']);  // remove white spaces, [, and ]
            $sort_keys = explode(',', $sort); //get all the key:direction pairs
            foreach ($sort_keys as $sort_key) {
                $direction = 'asc';
                $column = $sort_key;
                if (strpos($sort_key, ':')) {
                    list($column, $direction) = explode(':', $sort_key);
                }
                $sort_key_array[$column] = $direction;
            }
        }

        return $sort_key_array;
    }

    //create a new car
    public static function createCar($request){
        //retrieve parameters from request body
        $params = $request->getParsedBody();

        //create a new car instance;
        $car = new Cars();

        //set the car attributes;
        foreach($params as $field => $value){
            $car->$field = $value;
        }

        //insert the student to the db
        $car->save();
        return $car;
    }

    public static function updateCar($request){
        //retrieve parameters from request body
        $params = $request->getParsedBody();

        //retrieve the id from the request body
        $carId = $request->getAttribute('id');
        $car = self::find($carId);
        if(!$car){
            return false;
        }

        //update attributes of the car
        foreach($params as $field => $value){
            $car->$field = $value;
        }

        //save car into the database
        $car->save();
        return $car;
    }

    public static function deleteCar($request){
        //retrieve the id from the request
        $id = $request->getAttribute('id');
        $car = self::find($id);
        return($car ? $car->delete() : $car);
    }


}