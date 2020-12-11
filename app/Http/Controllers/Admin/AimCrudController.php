<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AimRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AimCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AimCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Aim::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/aim');
        CRUD::setEntityNameStrings('aim', 'aims');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns
        // CRUD::addColumn(['name' => 'name', 'type' => 'text']); 
        // add a "simple" filter called Draft
        $this->crud->addFilter([ 
            'type'  => 'simple',
            'name'  => 'is_other',
            'label' => 'Show no other',
           
        ],
        true, // the simple filter has no values, just the "Draft" label specified above
        function() { // if the filter is active (the GET parameter "draft" exits)
            $this->crud->addClause('where', 'is_other', '0'); 
          
        });

        
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AimRequest::class);

        $this->crud->addFields([
           
            [
                'type' => "text",
                'name' => 'name',
                'label' => 'Name'

            ],
            [
                'type' => "hidden",
                'name' => 'is_other',
                'value' =>'0'
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

    protected function setupInlineCreateOperation()
    {
        $this->crud->modifyField('is_other',
           
            [
                'type' => "hidden",
                'name' => 'is_other',
                'value' => '1'
            ],
        );
            
    }

}
