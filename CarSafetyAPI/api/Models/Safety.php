<?php
/**
 *   Author: Noah Johnson
 *   Date: 7/17/2021
 *   File: Safety.php
 *   Description:
 */

namespace SafeCar\Models;

use Illuminate\Database\Eloquent\Model;

class Safety extends Model{
    protected $table = 'safety';

    protected $primaryKey = 'rating';

   public $incrementing = false;

   protected $keyType = "int";

    public $timestamps = false;

    //set the relation between safety rating and cars...
    public function safetyCars(){
        return $this->hasMany('SafeCar\Models\Cars', 'carSafetyRating');
    }

    //retrieve all saftey ratings
    public static function getSafety() {
        $ratings = self::with('safetyCars')->get();
        return $ratings;
    }
    //View a specific Safety by id
    public static function getSafetyById(string $id) {
        $safety = self::findOrFail($id);
        $safety->load('safetyCars');
        return $safety;
    }
    //view all classes taught by a professor
    public static function getCarbySafety(string $id){
        $cars = self::findorFail($id)->safetyCars;
        return $cars;
    }
}