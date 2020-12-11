<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ActivityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ActivityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ActivityCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Activity::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/activity');
        CRUD::setEntityNameStrings('activity', 'activities');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->setColumns([
            [
                'label'     => "Output",
                'type'      => 'select',
                'name'      => 'output_id',
                'entity'    => 'output', 
                'model'     => "App\Models\Output",
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
        CRUD::setValidation(ActivityRequest::class);

        CRUD::addFields([ 
            [
                'label'     => "Output",
                'type'      => 'select',
                'name'      => 'output_id',
                'entity'    => 'output', 
                'model'     => "App\Models\Output",
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
                'label'     => "Output",
                'type'      => 'select',
                'name'      => 'output_id',
                'entity'    => 'output', 
                'model'     => "App\Models\Output",
                'attribute' => 'name',
              
            ],
            [
                'type' => "text",
                'name' => 'name',
                'label' => 'Name'

            ],
        ]);
       
      
    }

    public function fetchOutput()
    {
        return $this->fetch(Output::class);
    }

}
