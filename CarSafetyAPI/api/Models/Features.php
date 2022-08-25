<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/19/2021
 *   File: Features.php
 *   Description:
 */

namespace SafeCar\Models;

use Illuminate\Database\Eloquent\Model;

class Features extends Model{
    protected $table = 'features';

    protected $primaryKey = 'carSafetyFeatures';

    public $incrementing = false;

    protected $keyType = "varchar";

    public $timestamps = false;

    //set the relation between features and cars...
    public function featureCars(){
        return $this->hasMany('SafeCar\Models\Cars', 'carSafetyFeatures');
    }

    //search for student
    public static function searchFeatures($term){
        if(is_numeric($term)){
            $query = self::where('bonus', '>=', $term);
        } else {
            $query = self::where('class', 'like', "%$term%")
                ->orWhere('description', 'like', "%$term%")
                ->orWhere('carSafetyFeatures', 'like', "%$term%");
        }
        return $query->get();
    }

    //retrieve all features
    public static function getFeatures() {
        $specs = self::with('featureCars')->get();
        return $specs;

    }
    //View a specific features by id
    public static function getFeaturesById(string $id) {
        $features = self::findOrFail($id);
        $features->load('featureCars');
        return $features;
    }

    //create a new car
    public static function createFeature($request){
        //retrieve parameters from request body
        $params = $request->getParsedBody();

        //create a new feature instance;
        $feature = new Features();

        //set the car attributes;
        foreach($params as $field => $value){
            $feature->$field = $value;
        }

        //insert the student to the db
        $feature->save();
        return $feature;
    }

    public static function updateFeature($request){
        //retrieve parameters from request body
        $params = $request->getParsedBody();

        //retrieve the id from the request body
        $featureId = $request->getAttribute('id');
        $feature = self::find($featureId);
        if(!$feature){
            return false;
        }

        //update attributes of the car
        foreach($params as $field => $value){
            $feature->$field = $value;
        }

        //save car into the database
        $feature->save();
        return $feature;
    }

    public static function deleteFeature($request){
        //retrieve the id from the request
        $id = $request->getAttribute('id');
        $feature = self::find($id);
        return($feature ? $feature->delete() : $feature);
    }
}