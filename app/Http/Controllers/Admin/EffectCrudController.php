<?php

namespace App\Http\Controllers\Admin;

use App\Models\Evidence;
use App\Models\Indicator;
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
        
            [   // repeatable
                'name'  => 'indicator_repeat',
                'label' => 'This section collects information about indicators that measure the effect you have described. 

                If you are using one of the commonly used indicators provided, please select it. If you are using a different indicator, please describe it.
                
                You have freedom to use what you consider are the best indicators that provide the required evidence.
                
                If there is more than one indicator, please click on the "+ Add Indicator" sign to add space for a new indicator. You can enter as many as you need.',
                'type'  => 'repeatable',
                'fields' => [
                    [
                        'type' => "relationship",
                        'name' => 'indicators',
                        'ajax' => true,
                        'minimum_input_length' => 0,
                        'inline_create' => [ 'entity' => 'indicator' ],
                        'placeholder' => "Select a indicator",
                      
                    ],
                    [
                        'name'    => 'ind_value',
                        'type'    => 'number',
                        'label'   => 'Indicator Value',
                       
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
                    //     'type' => "relationship",
                    //     'name' => 'indicators_status',
                    //     'ajax' => true,
                    //     'minimum_input_length' => 0,
                    //     'inline_create' => [ 'entity' => 'indicator_status' ],
                    //     'placeholder' => "Select a Status", 
                    // ]
                    
                ],
            
                // optional
                'new_item_label'  => 'Add Indicator', // customize the text of the button
                
            ],

            // [
            //     'type' => "relationship",
            //     'name' => 'evidences',
            //     'ajax' => true,
            //     'minimum_input_length' => 0,
            //     'inline_create' => true,
            //     'placeholder' => "Select a Evidence",
              
            // ],

            [   // repeatable beneficiaries
                'name'  => 'beneficiaries_repeat',
                'label' => 'Beneficiaries',
                'type'  => 'repeatable',
                'fields' => [
                    [
                        'name'    => 'benef_description',
                        'type'    => 'text',
                        'label'   => 'Benficiarias desciption',
                       
                    ],                
                    [
                        'name'    => 'benef_type',
                        'type' => "text",
                        'label' => 'beneficiary type',
                       
                    ]
                    
                ],
            
                // optional
                'new_item_label'  => 'Add Beneficiary', // customize the text of the button
                
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

    public function fetchIndicators()
    {
        return $this->fetch(Indicator::class);
    }

    public function fetchEvidences()
    {
        return $this->fetch(Evidence::class);
    }
    
}
