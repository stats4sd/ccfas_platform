<?php

namespace App\Models;

use App\Models\Action;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use phpDocumentor\Reflection\Types\This;

class Effect extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'effects';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = ['file' => 'array', 'file' => 'array' ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getIndicatorRepeatAttribute()
    {
        $effects_indicators =  $this->link_effects_indicators->map(function ($effect_indicator, $key){

            return [
                'effect_indicator_id'=>$effect_indicator['id'],
                'indicators'=>$effect_indicator['indicator_id'],
                'level_attribution_id'=>$effect_indicator['level_attribution_id'],
                'baseline_qualitative'=>$effect_indicator['baseline_qualitative'],
                'baseline_quantitative'=>$effect_indicator['baseline_quantitative'],
            ];
   
        });

        $indicators_edit = [];
        foreach($effects_indicators as $effect_indicator){

        $indicator_values = IndicatorValue::where('link_effect_indicator_id', '=', $effect_indicator['effect_indicator_id'])->get();

            foreach($indicator_values as $indi_value){
        
                $effect_indicator['ind_value_id'] = $indi_value['id'];
                $effect_indicator['value_quantitative'] = $indi_value['value_quantitative'];
                $effect_indicator['value_qualitative'] = $indi_value['value_qualitative'];
                $effect_indicator['ind_url_source'] = $indi_value['url_source'];
                $effect_indicator['disaggregation_id[]'] = $indi_value['disaggregation_id'];
                // $effect_indicator['file_source'] = $indi_value['file_source'];
    
            }
            $indicators_edit[]= $effect_indicator;

        }
     
      
        return  $indicators_edit;        
    }

    public function getBeneficiariesRepeatAttribute()
    {
        return $this->beneficiaries->map(function ($beneficiary, $key) {
            return ['id'=>$beneficiary['id'],'beneficiary_type_id'=>$beneficiary['beneficiary_type_id'],'description'=>$beneficiary['description']];
        });
        
    }
    
    public function getEvidencesRepeatAttribute()
    {
        return $this->evidences->map(function ($evid, $key) {
            return ['id'=>$evid['id'],'description'=>$evid['description'],'files_description'=>$evid['files_description'], 'files'=>$evid['files'], 'urls'=>$evid['urls']];
        });
        
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function actions()
    {
        return $this->belongsToMany(Action::class, '_link_effects_actions');
    }

    public function indicators()
    {
        return $this->belongsToMany(Indicator::class, '_link_effects_indicators','effect_id', 'indicator_id')->withPivot('level_attribution_id')->withTimestamps();
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class);
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function link_effects_indicators()
    {
        return $this->hasMany(LinkEffectIndicator::class);
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

}
