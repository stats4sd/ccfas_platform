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

    public function subactivities()
    {
        return $this->belongsToMany(Subactivity::class, '_link_actions_subactivities');
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
