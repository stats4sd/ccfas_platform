<?php

namespace App\Http\Controllers\Admin;

use App\Models\Action;
use App\Models\Effect;
use App\Models\Evidence;
use App\Models\Indicator;
use App\Models\Beneficiary;
use App\Models\IndicatorValue;
use App\Models\BeneficiaryType;
use App\Models\LevelAttribution;
use App\Models\LinkEffectIndicator;
use App\Http\Requests\EffectRequest;
use App\Models\Change;
use App\Models\Disaggregation;
use App\Models\IndicatorStatus;

use function GuzzleHttp\json_decode;

use Illuminate\Support\Facades\Auth;
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
        CRUD::setValidation(EffectRequest::class);

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
                        'name'    => 'indicator_id',
                        'type' => "select_from_array",
                        'label' => 'Indicator ',
                      
                        // optional - force the related options to be a custom query, instead of all();
                        'options'   => $this->getIndicators(),     
                      
                    ],
                    [
                        'name'    => 'level_attribution_id',
                        'type' => "select_from_array",
                        'label' => 'level attribution',
                      
                        // optional - force the related options to be a custom query, instead of all();
                        'options'   => $this->getLevelAttributions(),     
                    ],
                    [
                        'name'    => 'ind_value',
                        'type'    => 'number',
                        'label'   => 'Indicator Value',
                       
                    ],
                    [
                        'name'    => 'qualitative',
                        'type'    => 'text',
                        'label'   => 'Indicator change qualitative',
                       
                    ],
                    [
                        'name'    => 'quantitative',
                        'type'    => 'text',
                        'label'   => 'Indicator change quantitative',
                       
                    ],
                    [
                        'name'    => 'ind_url_source',
                        'type'    => 'url',
                        'label'   => 'Indicators url Source',
                       
                    ],
                    [   // Upload
                        'name'      => 'file_source',
                        'label'     => 'Indicators File Source',
                        'type'      => 'upload',
                        'upload'    => true,
                        'disk'      => 'public', 
                    ],
                    [
                        'name'    => 'indicator_status_id',
                        'type' => "select_from_array",
                        'label' => 'Indicator Status',
                     
                        // optional - force the related options to be a custom query, instead of all();
                        'options'   =>  $this->getIndicatorStatus(),
                    ],
                    [
                        'name'    => 'disaggregation_id',
                        'type' => "select_from_array",
                        'label' => 'Disaggregation',
                      
                        // optional - force the related options to be a custom query, instead of all();
                        'options'   => $this->getDisaggregations(),   
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
                        'name'    => 'description',
                        'type'    => 'text',
                        'label'   => 'evidences desciption',                       
                    ],  
                    [
                        'name'    => 'files_description',
                        'type'    => 'text',
                        'label'   => 'file desciption',
                       
                    ],    
                    [   // Upload
                        'name'      => 'file',
                        'label'     => 'Evidence File',
                        'type'      => 'upload',
                        'upload'    => true,
                        'disk'      => 'uploads', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
                    ],
                    [
                        'name'    => 'url',
                        'type'    => 'url',
                        'label'   => 'Evidence url Source',
                       
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
                        'name'    => 'description',
                        'type'    => 'text',
                        'label'   => 'Benficiaries description',
                       
                    ],                
                    [
                        'name'    => 'beneficiary_type_id',
                        'type' => "select_from_array",
                        'label' => 'beneficiary type',
                        'allows_null' => false,
                      
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
        return BeneficiaryType::get()->pluck('name','id');
    }

    public function getIndicators()
    {
       return Indicator::get()->pluck('name','id');
    }

    public function getLevelAttributions()
    {
       return LevelAttribution::get()->pluck('name','id');
    }
    
    public function getIndicatorStatus()
    {
       return IndicatorStatus::get()->pluck('name','id');
    }

    public function getDisaggregations()
    {
       return Disaggregation::get()->pluck('name','id');
    }
    
    

    public function store(EffectRequest $request)
    {

      // do something before validation, before save, before everything

     
        $response = $this->traitStore();
        $effect = $this->crud->getCurrentEntry();
     
        $indicator_repeat = json_decode($request->indicator_repeat);
       
        foreach($indicator_repeat as $indicator ){

            // $effect_attribute = $effect->indicators()->attach($indicator->indicator_id, array('level_attribution_id'=>$indicator->level_attribution_id));
            $effect_indicator = LinkEffectIndicator::create([
                'effect_id' => $effect->id,
                'indicator_id' => $indicator->indicator_id,
                'level_attribution_id' => $indicator->level_attribution_id,
            ]);

          //problem with file
            $indicator_value = IndicatorValue::create([
                'link_effect_indicator_id' => $effect_indicator->id,
                'value' => $indicator->ind_value,
                'url_source' => $indicator->ind_url_source,
                'file_source' => $indicator->file_source,
                'indicator_status_id' => $indicator->indicator_status_id,
                'disaggregation_id'=> $indicator->disaggregation_id
            ]);
    
            $indicator_value->save();

            if(!empty($indicator->qualitative) || !empty($indicator->quantitative)){
                $change = Change::create([
                    'link_effect_indicator_id' => $effect_indicator->id,
                    'qualitative' => $indicator->qualitative,
                    'quantitative' => $indicator->quantitative ,
                ]);
            }
           
        }

        //Evidence repeat
        $evidence_repeat = json_decode($request->evidencies_repeat);
        
        foreach($evidence_repeat as $evidence ){
          //problem with file
            if(!empty($evidence->description)){
            $new_evidence = Evidence::create([
                'effect_id' =>  $effect->id,
                'description' => $evidence->description,
                'file' => $evidence->file,
                'urls' => $evidence->url,
                'files_description' => $evidence->files_description
            ]);
    
            $new_evidence->save();
            }
           
        }

         //Beneficiries repeat
         $beneficiaries_repeat = json_decode($request->beneficiaries_repeat);
        
         foreach($beneficiaries_repeat as $beneficiary ){
           //problem with file
            if(!empty($beneficiary->description)){
                $new_beneficiary  = Beneficiary::create([
                    'effect_id' =>  $effect->id,
                    'description' => $beneficiary->description,
                    'beneficiary_type_id' => $beneficiary->beneficiary_type_id,
                
                ]);
        
                $new_beneficiary->save();
            }
            
         }
 
 
        // do something after save
        return $response;
    }

   
    
}
