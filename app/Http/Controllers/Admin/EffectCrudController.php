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
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
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
            [   // repeatable
                'name'  => 'indicator_repeat',
                'label' => '<p>This section collects information about indicators that measure the effect you have described.</p>

                <p>If you are using one of the commonly used indicators provided, please select it. If you are using a different indicator, please describe it.</p>
                
                <p>You have freedom to use what you consider are the best indicators that provide the required evidence.</p>
                
                <p>If there is more than one indicator, please click on the "+ Add Indicator" sign to add space for a new indicator. You can enter as many as you need.</p>',
                'type'  => 'repeatable',
                'fields' => [
                
                    [
                        'name'  => 'indicator_label',
                        'type'  => 'custom_html',
                        'value' => '<h6><b>Indicator definition</b></h6><p>Please provide a full definition and if available a reference to a standard definition for this indicator.
                         This should include how the indicator is calculated and how the data is obtained.</p>
                         <p><b>We could break this down into more specific questions, but I am not sure if this would not impose a burden that is to high on the respondents</b></p>'
                    ],
                    // [
                    //     'name'    => 'indicator_id',
                    //     'type' => "select_from_array",
                    //     'label' => 'Indicator ',
                      
                    //     // optional - force the related options to be a custom query, instead of all();
                    //     'options'   => $this->getIndicators(),     
                      
                    // ],
                    [
                        'type' => "relationship",
                        'name' => 'indicators',
                        'ajax' => true,
                        'minimum_input_length' => 0,
                        'inline_create' => [ 'entity' => 'indicator' ],
                        'placeholder' => "Select an Indicator",
                        'label' =>'Select the indicator from the list. If it does not exist yet, please click on “+ Other” to add it.',
                        'multiple'=>false
                    ],
                    [
                        'name'    => 'value_qualitative',
                        'type'    => 'text',
                        'label'   => 'If the indicator you have chosen is qualitative, please describe that changes captures the size of effect you are reporting. This is how the indicator “changed” from its original condition',
                     
                    ],
                    [
                        'name'    => 'baseline_qualitative',
                        'type'   =>'text',
                        'label' => 'If you have a baseline for this indicator, what was its value at baseline? What is the value of the indicator now?<p></p><p></p>',
                     
                    ],
                    [
                        'name'    => 'value_quantitative',
                        'type'    => 'number',
                        'label'   => 'If the indicator you have chosen is quantitative, please indicate the size of the effect in numbers in the box below. This is how much has the indicator “changed” from its original value',
                        

                    ],
                    [
                        'name'    => 'baseline_quantitative',
                        'type'   =>'number',
                        'label' => 'If you have a baseline for this indicator, what was its value at baseline? What is the value of the indicator now?',
                       
                       
                    ],
                    [
                        'name' => 'effect_indicator_id',
                        'type' => "hidden",
                        'value' => null

                    ],
                    [
                        'name'    => 'ind_url_source',
                        'type'    => 'text',
                        'label'   => 'What was the source for this estimate of the indicator?
                        <p>Please provide a source that can be referenced. If it is on-line, please provide a URL.</p>',
                       
                    ],
                    [   // Upload
                        'name'      => 'file_source',
                        'label'     => 'If you have a document that supports this indicator has evidence, you can upload it here.',
                        'type'      => 'upload',
                        'upload'    => true,
                        'disk'      => 'public', 
                    ],
                    [
                        'name'    => 'level_attribution_id',
                        'type' => "select_from_array",
                        'label' => 'What is the level of attribution to the change in the indicator due to the work described?',
                      
                        // optional - force the related options to be a custom query, instead of all();
                        'options'   => $this->getLevelAttributions(),     
                      
                    ],
                    // [
                    //     'name'    => 'indicator_status_id',
                    //     'label' => 'Indicator Status',
                     
                    //     // optional - force the related options to be a custom query, instead of all();
                    //     'options'   =>  $this->getIndicatorStatus(),
                    // ],
                   
                    
                    [
                        'name'    => 'disaggregation_id',
                        'type' => "select_from_array",
                        'label' => 'Disaggregation',
                      
                        // optional - force the related options to be a custom query, instead of all();
                        'options'   => $this->getDisaggregations(),   
                        'default'   => null,
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
                        'name' => 'id',
                        'type' => "hidden",
                        'value' => null

                    ],
                    [
                        'name'    => 'description',
                        'type'    => 'text',
                        'label'   => 'Evidence desciption',                       
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
                        'name' => 'id',
                        'type' => "hidden",
                        'value' => null

                    ],
                    [
                        'name'    => 'beneficiary_type_id',
                        'type' => "select_from_array",
                        'label' => 'Beneficiary type',
                        'allows_null' => false,
                      
                        // optional - force the related options to be a custom query, instead of all();
                        'options'   => $this->getBeneficieryTypes(),     
                    ],
                    [
                        'name'    => 'description',
                        'type'    => 'textarea',
                        'label'   => 'Benficiaries description',
                       
                    ],                
                    
                ],
            
                // optional
                'new_item_label'  => 'Add Beneficiary', // customize the text of the button
                
            ],
            [
                'name'  => 'action_label',
                'type'  => 'custom_html',
                'value' => '<h6><b>Action</b></h6>In the next section you will describe the action in more detail: the objective, the affected agents, and details about its scope

                This will allow us to build a landscape of the actions and those affected. This picture will be overlaid on the project Logframe and the frameworks that describe Climate Smart Agriculture. Please be detailed in the description of objectives, effects and agents affected. The information you provide will be useful only if there is evidence that backs it up.'
               
              
            ],
            [
                'type' => "relationship",
                'name' => 'actions',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'action' ],
                'placeholder' => "Select an Action",
                'label' =>''
           
               
              
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
           if(!empty($indicator->indicators)){
                $effect_indicator = LinkEffectIndicator::create([
                    'effect_id' => $effect->id,
                    'indicator_id' => $indicator->indicators,
                    'level_attribution_id' => $indicator->level_attribution_id,
                    'baseline_quantitative' => $indicator->baseline_quantitative,
                    'baseline_qualitative' => $indicator->baseline_qualitative
                ]);
           }

          //problem with file
          if(!empty($indicator->value_qualitative) || !empty($indicator->value_quantitative) || !empty($indicator->ind_url_source) || !empty($indicator->file_source) || !empty($indicator->disaggregation_id)){
            $indicator_value = IndicatorValue::create([
                'link_effect_indicator_id' => $effect_indicator->id,
                'value_qualitative' => $indicator->value_qualitative,
                'value_quantitative' => $indicator->value_quantitative,
                'url_source' => $indicator->ind_url_source,
                'file_source' => $indicator->file_source,
                // 'indicator_status_id' => $indicator->indicator_status_id,
                'disaggregation_id'=> $indicator->disaggregation_id
            ]);
    
            $indicator_value->save();
          }

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

    public function update(EffectRequest $request)
    {
    

        $response = $this->traitUpdate();
        $effect = $this->crud->getCurrentEntry();
          //Beneficiries repeat
        $this->updateBeneficiary($request->beneficiaries_repeat, $effect->id);
        $this->updateEvidence($request->evidencies_repeat, $effect->id);
        $this->updateIndicator($request->indicator_repeat, $effect->id);
         // do something after save
        return $response;
    }

    public function updateIndicator($repeat, $effect_id)
    {

        $indicators_repeat = json_decode($repeat);
        foreach($indicators_repeat as $indicator ){
            $effect_indicator = LinkEffectIndicator::updateOrCreate(
                [
                    'id'=> $indicator->effect_indicator_id,
                ],
                [
                    'effect_id' => $effect_id,
                    'indicator_id' => $indicator->indicators,
                    'level_attribution_id' => $indicator->level_attribution_id,
                    'baseline_quantitative' => $indicator->baseline_quantitative,
                    'baseline_qualitative' => $indicator->baseline_qualitative,
                ]
            );
            $effect_indicator->save();
        }
        
    }

    public function updateBeneficiary($repeat, $effect_id)
    {
        $beneficiaries_repeat = json_decode($repeat);
    
        foreach($beneficiaries_repeat as $beneficiary ){
        //problem with file
            if(!empty($beneficiary->description)){
                $new_beneficiary  = Beneficiary::updateOrCreate(
                    [
                    'id' => $beneficiary->id
                    ],
                    [
                    'effect_id' =>  $effect_id,
                    'description' => $beneficiary->description,
                    'beneficiary_type_id' => $beneficiary->beneficiary_type_id,
                    ]
                
                );
        
                $new_beneficiary->save();
            }
            
        }
    }

    public function updateEvidence($repeat, $effect_id)
    {
        $evidence_repeat = json_decode($repeat);
    
        foreach($evidence_repeat as $evidence ){
        //problem with file
            if(!empty($evidence->description)){
                $new_evidence  = Evidence::updateOrCreate(
                    [
                    'id' => $evidence->id
                    ],
                    [
                        'effect_id' =>  $effect_id,
                        'description' => $evidence->description,
                        'file' => $evidence->file,
                        'urls' => $evidence->url,
                        'files_description' => $evidence->files_description
                    ]
                
                );
        
                $new_evidence->save();
            }
            
        }
    }

   
    
}
