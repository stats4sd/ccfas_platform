<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CsaFramework extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'csa_frameworks';
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
    public function actions()
    {
        return $this->belongsToMany(Action::class, '_link_actions_csa_frameworks', 'action_id', 'csa_framework_id');
    }

    public function pillars()
    {
        return $this->belongsToMany(Pillar::class, '_link_csa_frameworks_pillars');
    }

    public function systems()
    {
        return $this->belongsToMany(System::class, '_link_csa_frameworks_systems');
    }

    public function practices()
    {
        return $this->belongsToMany(Practice::class, '_link_csa_frameworks_practices');
    }

    public function enable_envs()
    {
        return $this->belongsToMany(EnableEnv::class, '_link_csa_frameworks_enable_envs');
    }

    public function elements()
    {
        return $this->belongsToMany(Element::class, '_link_csa_frameworks_elements');
    }

    public function investments()
    {
        return $this->belongsToMany(Investment::class, '_link_csa_frameworks_investments');
    }

    public function main_actions()
    {
        return $this->belongsToMany(MainAction::class, '_link_csa_frameworks_main_actions');
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
