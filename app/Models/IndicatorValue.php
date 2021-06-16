<?php

namespace App\Models;

use App\Models\Traits\HasUploadFields;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class IndicatorValue extends Model
{
    use CrudTrait, HasUploadFields;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'indicator_values';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = ['disaggregation_id' => 'array', 'file_source' => 'array', 'disaggreation_names'=>'array' ];

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
    public function indicator_status()
    {
        return $this->hasMany('App\Models\IndicatorStatus', 'indicator_status_id');
    }

    public function linkEffectIndicator()
    {
        return $this->belongsTo(LinkEffectIndicator::class);
    }

    public function disaggregation()
    {
        return $this->belongsTo(Disaggregation::class);
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
    public function setValueQuantitativeAttribute($value)
    {
        if(empty($value)){
            $this->attributes['value_quantitative'] = null;
           
        }else {
            $this->attributes['value_quantitative'] = $value;
          
        }
       
       
    }

    public function setFileSourceAttribute($value)
    {
        $attribute_name = "file_source";
        $disk = "public";
        $destination_path = "indicator_value";

        $this->uploadMultipleFilesToDiskFromRepeatable($value, $attribute_name, $disk, $destination_path);
    }

    public function getDisaggregationNamesAttribuite()
    {
        
        return $this->disaggregation->pluck('disaggregation_id');
    } 
}
