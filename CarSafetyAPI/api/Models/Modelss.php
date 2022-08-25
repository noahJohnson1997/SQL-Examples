<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/16/2021
 *   File: Models.php
 *   Description:
 */

namespace SafeCar\Models;

use Illuminate\Database\Eloquent\Model;

class Modelss extends Model{
    protected $table = 'models';

    protected $primaryKey = 'modelID';

    public $incrementing = false;

    protected $keyType = "char";

    public $timestamps = false;


    //set the relation for models and cars...
    public function modelCar(){
        return $this->hasMany('SafeCar\Models\Cars', 'carModelID');
    }

//    retrieve all models
    public static function getModelss($request) {

        //code for pagination...
        //get the total number of row count
        $count = self::count();

        //get querystring variables from url
        $params = $request->getQueryParams();

        //do limit and offset exist
        $limit = array_key_exists('limit', $params) ?  (int)$params['limit'] : 10; //items per page...
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0; //offset of the first item...

        //pagination
        $links = self::getLinks($request, $limit, $offset);

        //sorting
        $sort_key_array = self::getSortKeys($request);

        //query build
        $query = self::with('modelCar');
        $query = $query->skip($offset)->take($limit);

        //sort the output by one or more columns
        foreach ($sort_key_array as $column=>$direction){
            $query->orderBy($column, $direction);
        }

        $courses = $query->get();

        $results = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $courses
        ];

        return $results;

    }

    //View a specific Models by id
    public static function getModelssById(string $id) {
        $modelss = self::findorFail($id);
        $modelss->load('modelCar');
        return $modelss;
    }

    //search models
    public static function searchModels($term){
        if(is_numeric($term)){
            $query = self::where('price', '>=', $term);
        } else {
            $query = self::where('name', 'like', "%$term%")
                ->orWhere('description', 'like', "%$term%")
                ->orWhere('year', 'like', "%$term%")
                ->orWhere('modelID', 'like', "%$term%");
        }
        return $query->get();
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
}