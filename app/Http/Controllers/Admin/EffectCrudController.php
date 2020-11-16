<?php

namespace App\Http\Controllers\Admin;

use App\Models\Action;
use App\Models\Effect;
use App\Models\Indicator;
use App\Models\Beneficiary;
use App\Models\BeneficiaryType;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
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
            [  // Select
                'label'     => "Team",
                'type'      => 'select',
                'name'      => 'team_id', 
                'entity'    => 'teams', 
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
                'label'         => 'Provide a description of the effect you are reporting. There is no limit to the amount of information you can provide. ',
                'type'          => 'textarea',

            ],
            [
                'type' => "relationship",
                'name' => 'actions',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'action' ],
                'placeholder' => "Select an Action",
               
              
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
                    ]
                   
                    
                ],
            
                // optional
                'new_item_label'  => 'Add Indicator', // customize the text of the button
                
            ],
            [   // repeatable evidencies
                'name'  => 'evidencies_repeat',
                'label' => 'Evidence',
                'type'  => 'repeatable',
                'fields' => [
                    [
                        'name'    => 'evid_description',
                        'type'    => 'text',
                        'label'   => 'evidences desciption',                       
                    ],  
                    [
                        'name'    => 'evid_file_description',
                        'type'    => 'text',
                        'label'   => 'file desciption',
                       
                    ],    
                    [   // Upload
                        'name'      => 'evid_file',
                        'label'     => 'Evidence File',
                        'type'      => 'upload_multiple',
                        'upload'    => true,
                        'disk'      => 'uploads', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
                    ],
                    [
                        'name'    => 'ind_url_source',
                        'type'    => 'url',
                        'label'   => 'Indicators url Source',
                       
                    ],
                    
                ],
            
                // optional
                'new_item_label'  => 'Add Evidences', // customize the text of the button
                
            ],

            [   // repeatable beneficiaries
                'name'  => 'beneficiaries_repeat',
                'label' => 'Beneficiaries',
                'type'  => 'repeatable',
                'fields' => [
                    [
                        'name'    => 'benef_description',
                        'type'    => 'text',
                        'label'   => 'Benficiaries desciption',
                       
                    ],                
                    [
                        'name'    => 'benef_type',
                        'type' => "select_from_array",
                        'label' => 'beneficiary type',
                      
                        // optional - force the related options to be a custom query, instead of all();
                        'options'   => $this->getBeneficieryTypes(),     
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

    public function fetchActions()
    {
        return $this->fetch(Action::class);
    }

    public function getBeneficieryTypes()
    {
        $beneficiaries_types = BeneficiaryType::get();
        $types = [];
        foreach ($beneficiaries_types as $type) {
            array_push($types,$type->name);
        }
       
        return $types;

      
    }

    public function store(EffectRequest $request)
    {
      // do something before validation, before save, before everything
    //   dd($request->team_id);
        $effect = Effect::create([
            'team_id' => $request->team_id,
            'description' => $request->description

        ]);
      $response = $this->traitStore();
      // do something after save
      return $response;
    }

   
    
}
