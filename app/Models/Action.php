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

    public function csaframeworks()
    {
        return $this->belongsToMany(CsaFramework::class, '_link_actions_csa_frameworks', 'action_id', 'csa_framework_id');
    }

    public function subactivities()
    {
        return $this->belongsToMany(Subactivity::class, '_link_actions_subactivities');
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
