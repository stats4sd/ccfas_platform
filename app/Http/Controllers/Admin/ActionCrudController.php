<?php

namespace App\Http\Controllers\Admin;

use App\Models\Aim;
use App\Models\Product;
use App\Models\GeoBoundary;
use App\Models\ProductType;
use App\Http\Requests\ActionRequest;
use App\Models\CsaFramework;
use App\Models\Subactivity;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ActionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ActionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Action::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/action');
        CRUD::setEntityNameStrings('action', 'actions');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addFilter([ 
            'type'  => 'simple',
            'name'  => 'team_id',
            'label' => 'Team'
          ],
          false,
          function() { 
            $teams = backpack_user()->teams;
            
            $this->crud->addClause('whereIn', 'team_id', $teams); 
       
        });

        
        $this->crud->addColumns([
            [
                'label'     => "Team",
                'type'      => 'select',
                'name'      => 'team_id',
                'entity'    => 'team', 
                'model'     => "App\Models\Team",
                'attribute' => 'name',

            ],
            [
                'type' => "text",
                'name' => 'description',
                'label' => 'Description',

            ],

        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ActionRequest::class);

        CRUD::addFields([ 
            [  // Select
                'label'     => "Team",
                'type'      => 'select',
                'name'      => 'team_id', 
                'entity'    => 'team', 
                'model'     => "App\Models\Team", 
                'attribute' => 'name', 
                // optional - force the related options to be a custom query, instead of all();
                'options'   => (function ($query) {
                    $teams =  backpack_user()->teams()->pluck('teams.id')->toArray();
                   
                    return $query->whereIn('id', $teams)->get();
                 }), 
                
            ],
            [
                'name'          => 'description',
                'label'         => 'Provide a description of the action you are reporting. There is no limit to the amount of information you can provide. ',
                'type'          => 'textarea',
                
            ],
            [
                'name'          => 'start',
                'label'         => 'Start',
                'type'          => 'date',
            ],
            [
                'name'          => 'end',
                'label'         => 'End',
                'type'          => 'date',
            ],
            [
                'type' => "relationship",
                'name' => 'geoboundaries',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'geoboundary' ],
                'placeholder' => "Select an Geo Boundaries",  
                'label' => 'Describe the boundaries of the geographic area where the action has taken place.'
              
            ],
            [
                'type' => "relationship",
                'name' => 'aims',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'aim' ],
                'placeholder' => "What did you seek to achieve through this action",
              
            ],
            [
                'type' => "relationship",
                'name' => 'scopes',
                'placeholder' => "How would you describe the intended scope of the action?",
                
            ],
            [
                'type' => "relationship",
                'name' => 'ipflows',
                'placeholder' => "In which part of the IP flow is the action taking place?",
                
            ],
            [
                'type' => "relationship",
                'name' => 'products',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'product' ],
                'placeholder' => "Select an Product",
                'attribute' =>'name_display'
                
            ],
            [
                'type' => "relationship",
                'name' => 'subactivities',
                'placeholder' => "Select an Subactivity",
                
            ],
            [
                'type' => "relationship",
                'name' => 'pillars',
                'placeholder' => "Select Pillars",  
              
            ],
            [
                'type' => "relationship",
                'name' => 'systems',
                'placeholder' => "Select Systems",  
              
            ],
            [
                'type' => "relationship",
                'name' => 'practices',
                'placeholder' => "Select Practices",  
              
            ],
            [
                'type' => "relationship",
                'name' => 'enable_envs',
                'placeholder' => "Select Enable Env",  
              
            ],
            [
                'type' => "relationship",
                'name' => 'elements',
                'placeholder' => "Select Elements",  
              
            ],
            [
                'type' => "relationship",
                'name' => 'investments',
                'placeholder' => "Select an Investments",  
              
            ],
            [
                'type' => "relationship",
                'name' => 'main_actions',
                'placeholder' => "Select an Main Actions",  
              
            ]
        ]);

       
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function fetchAims()
    {
        return $this->fetch([
            'model' => Aim::class,
            'query' => function ($model) {
            return $model->where('is_other', '=', false);
            }
        ]);
    }
    public function fetchGeoboundaries()
    {
        return $this->fetch(GeoBoundary::class);
    }

    public function fetchProducts()
    {
        return $this->fetch(Product::class);
    }

}
