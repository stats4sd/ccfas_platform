<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubactivityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubactivityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubactivityCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Subactivity::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subactivity');
        CRUD::setEntityNameStrings('subactivity', 'subactivities');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setColumns([ 
            [
                'label'     => "Activity",
                'type'      => 'select',
                'name'      => 'activity_id',
                'entity'    => 'activity', 
                'model'     => "App\Models\Activity",
                'attribute' => 'name',
              
            ],
            [
                'type' => "text",
                'name' => 'name',
                'label' => 'Name'

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
        CRUD::setValidation(SubactivityRequest::class);

        CRUD::addFields([ 
            [
                'label'     => "Activity",
                'type'      => 'select',
                'name'      => 'activity_id',
                'entity'    => 'activity', 
                'model'     => "App\Models\Activity",
                'attribute' => 'name',
              
            ],
            [
                'type' => "text",
                'name' => 'name',
                'label' => 'Name'

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

    protected function setupShowOperation()
    {
        // by default the Show operation will try to show all columns in the db table,
        // but we can easily take over, and have full control of what columns are shown,
        // by changing this config for the Show operation 
        $this->crud->set('show.setFromDb', false);

        CRUD::setColumns([ 
            [
                'label'     => "Activity",
                'type'      => 'select',
                'name'      => 'activity_id',
                'entity'    => 'activity', 
                'model'     => "App\Models\Activity",
                'attribute' => 'name',
              
            ],
            [
                'type' => "text",
                'name' => 'name',
                'label' => 'Name'

            ],
        ]);
       
      
    }
}
