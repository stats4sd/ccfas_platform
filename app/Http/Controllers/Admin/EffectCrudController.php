<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EffectRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EffectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EffectCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        CRUD::setModel(\App\Models\Effect::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/effect');
        CRUD::setEntityNameStrings('effect', 'effects');
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

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EffectRequest::class);

        CRUD::addFields([ 
            [
                'name'          => 'description',
                'label'         => 'Provide a description of the effect you are reporting. There is no limit to the amount of information you can provide. ',
                'type'          => 'textarea'
            ],
            [   // SelectMultiple = n-n relationship (with pivot table)
                'label'     => "Actions",
                'type'      => 'select2_multiple',
                'name'      => 'actions', // the method that defines the relationship in your Model
            
                // optional
                'entity'    => 'actions', // the method that defines the relationship in your Model
                'model'     => "App\Models\Action", // foreign key model
                'attribute' => 'description', // foreign key attribute that is shown to user
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            
            ],  
            [
                'name'          => 'evidence',
                'label'         => 'Provide evidence to back up your claim of an effect?',
                'type'          => 'textarea'

            ],
            [   // SelectMultiple = n-n relationship (with pivot table)
                'label'     => "Select Indicators",
                'type'      => 'select2_multiple',
                'name'      => 'indicators', // the method that defines the relationship in your Model
            
                // optional
                'entity'    => 'indicators', // the method that defines the relationship in your Model
                'model'     => "App\Models\Indicator", // foreign key model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            
            ],  
            [   // repeatable
                'name'  => 'indicator_repeat',
                'label' => 'This section collects information about indicators that measure the effect you have described. 

                If you are using one of the commonly used indicators provided, please select it. If you are using a different indicator, please describe it.
                
                You have freedom to use what you consider are the best indicators that provide the required evidence.
                
                If there is more than one indicator, please click on the "+ Add Indicator" sign to add space for a new indicator. You can enter as many as you need.',
                'type'  => 'repeatable',
                'fields' => [
                    [
                        'name'    => 'ind_name',
                        'type'    => 'text',
                        'label'   => 'Indicator definition',
        
                    ],
                    [
                        'name'    => 'ind_definition',
                        'type'    => 'text',
                        'label'   => 'Indicator definition',
        
                    ],
                    [
                        'name'    => 'ind_url_source',
                        'type'    => 'url',
                        'label'   => 'Indicators url Source',
                       
                    ],
                    [   // Upload
                        'name'      => 'ind_file_source',
                        'label'     => 'Indicators File Source',
                        'type'      => 'upload_multiple',
                        'upload'    => true,
                        'disk'      => 'uploads', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
                    ],
                    // [
                    //     'name'    => 'ind_status',
                    //     'type'    => 'select',
                    //     'label'   => 'Status',
                    //     'entity'    => 'indicator_status', 
                    //     'model'     => "App\Models\IndicatorStatus", // related model
                    //     'attribute' => 'name', 
                       
                    // ],
                    [
                        'name'  => 'ind_now',
                        'type'  => 'number',
                        'label' => 'What is the value of the indicator now?',
                       
                    ],
                ],
            
                // optional
                'new_item_label'  => 'Add Indicator', // customize the text of the button
                
            ],
  
        

            
        ]);
        
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
}
