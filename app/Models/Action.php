<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'actions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $appends = ['output_id', 
    'geo_boundary_id', 
    'subactivities_numbers', 
    'activities_numbers', 
    'outputs_numbers', 
    'milestones_numbers', 
    'pillar_sustainability',
    'pillar_adpating',
    'pillar_reducing',
    'system_value_chains',
    'system_landscape_management',
    'practices_energy_management',
    'capture_fisheries',
    'forestry_agroforestry',
    'livestock_management',
    'water_management',
    'crop_production',
    'soil_management',
    'services_for_farmers',
    'ecosystem',
    'management_of_farms',
    'exploiting_opportunities',
    'understanding_and_planning',
    'managing_climate_risks',
    'enhancing_financing',
    'strengthening_national',
    'building_policy_frameworks',
    'expanding_evidence',
    'gender',
    'institutional_arrangements',
    'policy_engagement',
    'infrastructure',
    'climate_information_services',
    'index_based_insurance',
    'scope_localised',
    'scope_local_plus',
    'country_wide',
    'multi_country',
    'global',
    'basic',
    'roll_out',
    'dissemination'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getOutputIdAttribute()
    {
        if ($this->activities->count() > 0) {
            return $this->activities()->first()->output_id;
        }
        return null;
    }

    public function getGeoBoundaryIdAttribute()
    {
        if ($this->geoboundaries()->count() > 0) {
            $geo_ids='';
            $geoboundaries = $this->geoboundaries()->get();
            foreach($geoboundaries as $geo){
                if($this->geoboundaries()->count()==1){
                    return $geo->id;
                }
                $geo_ids = $geo->id.', '.$geo_ids;
            }
           return $geo_ids;
        }
        return 'null';
    }

    public function getSubactivitiesNumbersAttribute()
    {
        if ($this->subactivities()->count() > 0) {
            $sub_names='';
            $subactivities = $this->subactivities()->get();
            foreach($subactivities as $sub){
                if($this->subactivities()->count()==1){

                    return substr($sub->name,0, 5);
                }
                
                $sub_names = substr($sub->name, 0, 5).', '.$sub_names;
            }
           return $sub_names;
        }
        return 'null';
    }

    public function getActivitiesNumbersAttribute()
    {
        if ($this->activities()->count() > 0) {
            $act_names='';
            $activities = $this->activities()->get();
            foreach($activities as $act){
                if($this->activities()->count()==1){

                    return substr($act->name, 9, 3);
                }
                
                $act_names = substr($act->name, 9, 3).', '.$act_names;
            }
           return $act_names;
        }
        return 'null';
    }

    public function getOutputsNumbersAttribute()
    {
        
        if ($this->activities()->count() > 0) {
            $out_names='';
            $activities = $this->activities()->get();
            
            foreach($activities as $act){

                $output_name = Output::find($act->output_id)->name;
                if($this->activities()->count()==1){
                    return substr($output_name, 6, 2);
                }
                
                $out_names = substr($output_name, 6, 2).', '.$out_names;
            }
           return $out_names;
        }
        return 'null';
    }

    public function getMilestonesNumbersAttribute()
    {
        if ($this->milestones()->count() > 0) {
            $milestone_names='';
            $milestones = $this->milestones()->get();
            foreach($milestones as $milestone){
                if($this->milestones()->count()==1){

                    return substr($milestone->name, 0, 2);
                }
                
               $milestone_names = substr($milestone->name, 0, 2).', '.$milestone_names;
            }
           return $milestone_names;
        }
        return 'null';
    }

    public function getPillarSustainabilityAttribute()
    {
        if ($this->pillars()->count() > 0) {
            $pillars = $this->pillars()->get();
            foreach($pillars as $pillar){
                if($pillar->id==1){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getPillarAdpatingAttribute()
    {
        if ($this->pillars()->count() > 0) {
            $pillars = $this->pillars()->get();
            foreach($pillars as $pillar){
                if($pillar->id==2){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getPillarReducingAttribute()
    {
        if ($this->pillars()->count() > 0) {
            $pillars = $this->pillars()->get();
            foreach($pillars as $pillar){
                if($pillar->id==3){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getSystemValueChainsAttribute()
    {
        if ($this->systems()->count() > 0) {
            $systems = $this->systems()->get();
            foreach($systems as $system){
                if($system->name=='Value chains'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getSystemLandscapeManagementAttribute()
    {
        if ($this->systems()->count() > 0) {
            $systems = $this->systems()->get();
            foreach($systems as $system){
                if($system->name=='Landscape management'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getPracticesEnergyManagementAttribute()
    {
        if ($this->systems()->count() > 0) {
            $systems = $this->systems()->get();
            foreach($systems as $system){
                if($system->name=='Energy management'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getCaptureFisheriesAttribute()
    {
        if ($this->systems()->count() > 0) {
            $systems = $this->systems()->get();
            foreach($systems as $system){
                if($system->name=='Capture fisheries and aquaculture'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getForestryAgroforestryAttribute()
    {
        if ($this->systems()->count() > 0) {
            $systems = $this->systems()->get();
            foreach($systems as $system){
                if($system->name=='Forestry and agroforestry'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getLivestockManagementAttribute()
    {
        if ($this->systems()->count() > 0) {
            $systems = $this->systems()->get();
            foreach($systems as $system){
                if($system->name=='Livestock management'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getWaterManagementAttribute()
    {
        if ($this->systems()->count() > 0) {
            $systems = $this->systems()->get();
            foreach($systems as $system){
                if($system->name=='Water management'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getCropProductionAttribute()
    {
        if ($this->systems()->count() > 0) {
            $systems = $this->systems()->get();
            foreach($systems as $system){
                if($system->name=='Crop production'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getSoilManagementAttribute()
    {
        if ($this->systems()->count() > 0) {
            $systems = $this->systems()->get();
            foreach($systems as $system){
                if($system->name=='Soil management'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getServicesForFarmersAttribute()
    {
        if ($this->elements()->count() > 0) {
            $elements = $this->elements()->get();
            foreach($elements as $element){
                if($element->id==3){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getEcosystemAttribute()
    {
        if ($this->elements()->count() > 0) {
            $elements = $this->elements()->get();
            foreach($elements as $element){
                if($element->id==2){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getManagementOfFarmsAttribute()
    {
        if ($this->elements()->count() > 0) {
            $elements = $this->elements()->get();
            foreach($elements as $element){
                if($element->id==1){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getExploitingOpportunitiesAttribute()
    {
        if ($this->investments()->count() > 0) {
            $investments = $this->investments()->get();
            foreach($investments as $investment){
                if($investment->id==3){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getUnderstandingAndPlanningAttribute()
    {
        if ($this->investments()->count() > 0) {
            $investments = $this->investments()->get();
            foreach($investments as $investment){
                if($investment->id==2){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getManagingClimateRisksAttribute()
    {
        if ($this->investments()->count() > 0) {
            $investments = $this->investments()->get();
            foreach($investments as $investment){
                if($investment->id==1){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getEnhancingFinancingAttribute()
    {
        if ($this->main_actions()->count() > 0) {
            $main_actions = $this->main_actions()->get();
            foreach($main_actions as $main_action){
                if($main_action->id==4){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getStrengtheningNationalAttribute()
    {
        if ($this->main_actions()->count() > 0) {
            $main_actions = $this->main_actions()->get();
            foreach($main_actions as $main_action){
                if($main_action->id==3){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getBuildingPolicyFrameworksAttribute()
    {
        if ($this->main_actions()->count() > 0) {
            $main_actions = $this->main_actions()->get();
            foreach($main_actions as $main_action){
                if($main_action->id==2){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getExpandingEvidenceAttribute()
    {
        if ($this->main_actions()->count() > 0) {
            $main_actions = $this->main_actions()->get();
            foreach($main_actions as $main_action){
                if($main_action->id==1){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getGenderAttribute()
    {
        if ($this->enable_envs()->count() > 0) {
            $enable_envs = $this->enable_envs()->get();
            foreach($enable_envs as $enable_env){
                if($enable_env->name=='Gender and social inclusion'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getInstitutionalArrangementsAttribute()
    {
        if ($this->enable_envs()->count() > 0) {
            $enable_envs = $this->enable_envs()->get();
            foreach($enable_envs as $enable_env){
                if($enable_env->name=='Institutional arrangements'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getPolicyEngagementAttribute()
    {
        if ($this->enable_envs()->count() > 0) {
            $enable_envs = $this->enable_envs()->get();
            foreach($enable_envs as $enable_env){
                if($enable_env->name=='Policy engagement'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getInfrastructureAttribute()
    {
        if ($this->enable_envs()->count() > 0) {
            $enable_envs = $this->enable_envs()->get();
            foreach($enable_envs as $enable_env){
                if($enable_env->name=='Infrastructure'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getClimateInformationServicesAttribute()
    {
        if ($this->enable_envs()->count() > 0) {
            $enable_envs = $this->enable_envs()->get();
            foreach($enable_envs as $enable_env){
                if($enable_env->name=='Climate information services'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getIndexBasedInsuranceAttribute()
    {
        if ($this->enable_envs()->count() > 0) {
            $enable_envs = $this->enable_envs()->get();
            foreach($enable_envs as $enable_env){
                if($enable_env->name=='Index-based insurance'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getScopeLocalisedAttribute()
    {
        if ($this->scopes()->count() > 0) {
            $scopes = $this->scopes()->get();
            foreach($scopes as $scope){
                if($scope->name=='Localised (boundaries known)'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getScopeLocalPlusAttribute()
    {
        if ($this->scopes()->count() > 0) {
            $scopes = $this->scopes()->get();
            foreach($scopes as $scope){
                if($scope->name=='Local plus (spill over expected)'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getCountryWideAttribute()
    {
        if ($this->scopes()->count() > 0) {
            $scopes = $this->scopes()->get();
            foreach($scopes as $scope){
                if($scope->name=='Country wide (one country)'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getMultiCountryAttribute()
    {
        if ($this->scopes()->count() > 0) {
            $scopes = $this->scopes()->get();
            foreach($scopes as $scope){
                if($scope->name=='Multi-country'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getGlobalAttribute()
    {
        if ($this->scopes()->count() > 0) {
            $scopes = $this->scopes()->get();
            foreach($scopes as $scope){
                if($scope->name=='Global'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getBasicAttribute()
    {
        if ($this->ipflows()->count() > 0) {
            $ipflows = $this->ipflows()->get();
            foreach($ipflows as $ipflow){
                if($ipflow->name=='Basic, fundamental research /new knowledge generation'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getRollOutAttribute()
    {
        if ($this->ipflows()->count() > 0) {
            $ipflows = $this->ipflows()->get();
            foreach($ipflows as $ipflow){
                if($ipflow->name=='Roll out/implementation/adoption by intermediary or next users'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }

    public function getDisseminationAttribute()
    {
        if ($this->ipflows()->count() > 0) {
            $ipflows = $this->ipflows()->get();
            foreach($ipflows as $ipflow){
                if($ipflow->name=='	Dissemination/uptake by end users'){
                    return 1;
                } else {
                    return '0';
                }
            }
        }
    }






    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function effects()
    {
        return $this->belongsToMany(Effect::class, '_link_effects_actions');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, '_link_actions_products');
    }

    public function aims()
    {
        return $this->belongsToMany(Aim::class, '_link_actions_aims');
    }

    public function ipflows()
    {
        return $this->belongsToMany(Ipflow::class, '_link_actions_ipflows');
    }

    public function scopes()
    {
        return $this->belongsToMany(Scope::class, '_link_actions_scopes');
    }

    public function geoboundaries()
    {
        return $this->belongsToMany(GeoBoundary::class, '_link_actions_geo_boundaries');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, '_link_actions_activities');
    }

    public function subactivities()
    {
        return $this->belongsToMany(Subactivity::class, '_link_actions_subactivities');
    }

    public function milestones()
    {
        return $this->belongsToMany(Milestone::class, '_link_actions_milestones');
    }

    public function pillars()
    {
        return $this->belongsToMany(Pillar::class, '_link_actions_pillars');
    }

    public function systems()
    {
        return $this->belongsToMany(System::class, '_link_actions_systems');
    }

    public function practices()
    {
        return $this->belongsToMany(Practice::class, '_link_actions_practices');
    }

    public function enable_envs()
    {
        return $this->belongsToMany(EnableEnv::class, '_link_actions_enable_envs');
    }

    public function elements()
    {
        return $this->belongsToMany(Element::class, '_link_actions_elements');
    }

    public function investments()
    {
        return $this->belongsToMany(Investment::class, '_link_actions_investments');
    }

    public function main_actions()
    {
        return $this->belongsToMany(MainAction::class, '_link_actions_main_actions');
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
