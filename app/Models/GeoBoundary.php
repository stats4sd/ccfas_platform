<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class GeoBoundary extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'geo_boundaries';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $appends = ['country_ids', 'country_names'];


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function actions()
    {
        return $this->belongsToMany(Action::class, '_link_actions_geo_boundaries');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, '_link_geo_boundaries_countries');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getCountryIdsAttribute()
    {
        if ($this->countries()->count() > 0) {
            $country_ids='';
            $countries = $this->countries()->get();
            foreach($countries as $country){
                if($this->countries()->count()==1){
                    return $country->id;
                }
                $country_ids = $country->id .', '.$country_ids;
            }
           return $country_ids;
        }
        return 'null';
    }

    public function getCountryNamesAttribute()
    {
        if ($this->countries()->count() > 0) {
            $country_names='';
            $countries = $this->countries()->get();
            foreach($countries as $country){
                if($this->countries()->count()==1){
                    return $country->name;
                }
                $country_names = $country->name.', '.$country_names;
            }
           return $country_names;
        }
        return 'null';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
