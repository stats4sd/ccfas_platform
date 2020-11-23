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
                // 'value_qualitative'=>$indicator_value['value_qualitative'],
                // 'value_quantitative'=>$indicator_value['value_quantitative'],
                'baseline_qualitative'=>$effect_indicator['baseline_qualitative'],
                'baseline_quantitative'=>$effect_indicator['baseline_quantitative'],
                // 'ind_url_source'=>$indicator_value['url_source'],
                // 'file_source'=>$indicator_value['file_source'],
            ];
        
   
        });


        // foreach($effects_indicators as $effect_indicator){
                    
        // $indicator_value = IndicatorValue::where('link_effect_indicator_id', '=', $effect_indicator['effect_indicator_id'])->first();

        //    $effect_indicator['value_qualitative'] = $indicator_value['value_quantitative']; 
        //    $effect_indicator['value_qualitative'] = $indicator_value['value_qualitative'];
        //    $effect_indicator['ind_url_source'] = $indicator_value['url_source'];
        //    $effect_indicator['file_source'] = $indicator_value['file_source'];
    
           
        // }
        
                //   dd($effects_indicators);


        return  $effects_indicators;        
    }

    public function getBeneficiariesRepeatAttribute()
    {
        return $this->beneficiaries->map(function ($beneficiary, $key) {
            return ['id'=>$beneficiary['id'],'beneficiary_type_id'=>$beneficiary['beneficiary_type_id'],'description'=>$beneficiary['description']];
        });
        
    }
    
    public function getEvidenciesRepeatAttribute()
    {
        return $this->evidences->map(function ($evid, $key) {
            return ['id'=>$evid['id'],'description'=>$evid['description'],'files_description'=>$evid['files_description'], 'files'=>$evid['file'], 'urls'=>$evid['url']];
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
