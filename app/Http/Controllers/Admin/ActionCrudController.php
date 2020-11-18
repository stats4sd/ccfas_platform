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
              
            ],
            [
                'type' => "relationship",
                'name' => 'aims',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'aim' ],
                'placeholder' => "Select an Aim",
              
            ],
            [
                'type' => "relationship",
                'name' => 'scopes',
                'placeholder' => "Select an Scope",
                
            ],
            [
                'type' => "relationship",
                'name' => 'ipflows',
                'placeholder' => "Select an Ipflow",
                
            ],
            [
                'type' => "relationship",
                'name' => 'products',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'product' ],
                'placeholder' => "Select an Product",
                
            ],
            [
                'type' => "relationship",
                'name' => 'subactivities',
                'placeholder' => "Select an Subactivity",
                
            ],
            [
                'type' => "relationship",
                'name' => 'csaframeworks',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'csaframework' ],
                'placeholder' => "Select an CSA Framework",
                
            ],
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
        return $this->fetch([
            'model' => Product::class, // required
            'searchable_attributes' => ['publication'],
            
        
        ]);
    }
    public function fetchCsaframeworks()
    {
        return $this->fetch(CsaFramework::class);
    }


}
