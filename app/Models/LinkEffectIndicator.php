<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class LinkEffectIndicator extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = '_link_effects_indicators';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

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
    public function effect()
    {
        return $this->belongsTo(Effect::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function indicatorValues()
    {
        return $this->hasMany(IndicatorValue::class);
    }

    public function levelAttribution()
    {
        return $this->belongsTo(LevelAttribution::class);
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setBaselineQuantitativeAttribute($value)
    {
        
        if(empty($value)){
            $this->attributes['baseline_quantitative'] = null;
           
        }else {
            $this->attributes['baseline_quantitative'] = $value;
          
        }
       
    }

}
