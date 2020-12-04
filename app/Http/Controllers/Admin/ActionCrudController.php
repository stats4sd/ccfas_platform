<?php

namespace App\Http\Controllers\Admin;

use App\Models\Aim;
use App\Models\Product;
use App\Models\GeoBoundary;
use App\Http\Requests\ActionRequest;
use App\Models\Activity;
use App\Models\Effect;
use App\Models\Milestone;
use App\Models\Output;
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

        $this->crud->addFilter([ 
            'type'  => 'simple',
            'name'  => 'completed',
            'label' => 'Not Completed'
          ],
          false,
          function() { 
            
            $this->crud->addClause('where', 'completed', '0'); 
       
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
            [
                'type' => "check",
                'name' => 'completed',
                'label' => 'Completed',

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
            [   // CustomHTML
                'name'  => 'separator',
                'type'  => 'custom_html',
                'value' => '<h6><b>The "Action" that produced the effect </b></h6>
                <p>In the next section you will describe the action in more detail: the objective, the affected agents, and details about its scope 

                This will allow us to build a landscape of the actions and those affected. This picture will be overlaid on the project Logframe and the frameworks that describe Climate Smart Agriculture.
                Please be detailed in the description of objectives, effects and agents affected. The information you provide will be useful only if there is evidence that backs it up. </p>
                ',
                'tab' => 'Action'
            ],
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
                'tab' => 'Action'
                
            ],
            [
                'type' => "hidden",
                'name' => 'completed',
                'value' => '1',
                'tab' => 'Action'
            ],
            [
                'name'          => 'description',
                'label'         => 'Provide a description of the action you are reporting. There is no limit to the amount of information you can provide. ',
                'type'          => 'textarea',
                'tab'            => 'Action'
            ],
            [
                'name'          => 'start',
                'label'         => 'When did the action that cause the effect start? ',
                'type'          => 'date',
                'hint'          => "if you don't know the exact date, the month and year are enough",
                'tab'           => 'Action'
            ],
            [
                'name'          => 'end',
                'label'         => 'If the action has finished, please state the date ',
                'type'          => 'date',
                'hint'          => "if you don't know the exact date, the month and year are enough",
                'tab'           => 'Action'
            ],
            [   // CustomHTML
                'name'  => 'geoboundaries_label',
                'type'  => 'custom_html',
                'value' => '<b>In this question you can describe the geographical area covered by the action by clicking on "+Other" or select an area already specified by your team where some of the actions reported have taken place</b>',
                'tab' => 'Action'
            ],
            [
                'type' => "relationship",
                'name' => 'geoboundaries',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'geoboundary' ],
                'placeholder' => "Select an Geo Boundaries",  
                'label' => '',
                'tab' => 'Action'
              
            ],
            [   // CustomHTML
                'name'  => 'details_action',
                'type'  => 'custom_html',
                'value' => '<h6><b>Details of the Action </b></h6>
                <p>In the next section you will describe the action in more detail: the objective, the affected agents, and details about its scope </p>
                <p>This will allow us to build a landscape of the actions and those affected. This picture will be overlaid on the project Logframe and the frameworks that describe Climate Smart Agriculture. 
                Please be detailed in the description of objectives, effects and agents affected. The information you provide will be useful only if there is evidence that backs it up. </p>
                ',
                'tab' => 'Details of the Action'
            ],
            [
                'type' => "relationship",
                'name' => 'aims',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'aim' ],
                'label' => "What did you seek to achieve through this action? ",
                'hint' => 'You can select more than one or add a new aim if it does not exist by clicking on "+Other"',
                'tab' => 'Details of the Action'
            ],
            [
                'type' => "relationship",
                'name' => 'scopes',
                'label' => "How would you describe the intended scope of the action?",
                'hint' => 'You can select more than one ',
                'tab' => 'Details of the Action'
            ],
            [
                'type' => "relationship",
                'name' => 'ipflows',
                'label' => "In which part of the IP flow is the action taking place? ",
                'hint' => 'You can select more than one ',
                'tab' => 'Details of the Action'
            ],
            [   // CustomHTML
                'name'  => 'product_details',
                'type'  => 'custom_html',
                'value' => '<h6><b>Products generated </b></h6>
                <p>An action may or may not generate products, but if there are any products associated with the action you have reported please describe them </p>
                <p>These are tangible goods that are made available to interested people. </p>',
                'tab' => 'Products generated'
            ],
            [
                'type' => "relationship",
                'name' => 'products',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [ 'entity' => 'product' ],
                'placeholder' => "Select a Product",
                'attribute' =>'name_display',
                'label' => 'Select a product type and describe the specific product generated by the action ',
                'tab' => 'Products generated'
                
            ],
            [   // CustomHTML
                'name'  => 'logframe_details',
                'type'  => 'custom_html',
                'value' => '<h6><b>The Action in reference to the project Logframe </b></h6>
                <p>In the this section you will place the action within the project Logframe. Please complete all the questions </p>',
                'tab' => 'Log Framework'
            ],
            [
                'type' => "select_from_array",
                'name' => 'outputs',
                'placeholder' => "Select an Output",
                'label' => 'Select the Output under which this action falls',
                'options'   => $this->getOutputs(),   
                'tab' => 'Log Framework'
                
            ],
            [
                'type' => "select2_from_ajax_multiple",
                'name' => 'activities',
                'placeholder' => "Select an Activity",
                'label' => 'Select the Activity under which this action falls ',
                'minimum_input_length' => 0,
                'multiple' => false, 
                'dependecies' => ['output_id'],
                'entity'      => 'activities', // the method that defines the relationship in your Model
                'attribute'   => "name", // foreign key attribute that is shown to user
                'data_source' => backpack_url('action/fetch/activity'), // url to controller search function (with /{id} should return model)
                'method' => 'post',
                'include_all_form_fields' => true,
                'pivot' => true,
                'tab' => 'Log Framework'
            ],
            [
                'type' => "relationship",
                'name' => 'subactivities',
                'placeholder' => "Select a Subactivity",
                'label' => 'Select the sub activity under which this action falls ',
                'minimum_input_length' => 0,
                'multiple' => true, 
                'ajax' => true, 
                'dependecies' => ['activity_id'],
                'tab' => 'Log Framework'  
            ],
            [
                'type' => "relationship",
                'name' => 'milestones',
                'placeholder' => "Select a Milestone",
                'label' => 'Select the milestones associated with this activity ',
                'minimum_input_length' => 0,
                'ajax' => true, 
                'dependecies' => ['activity_id'],
                'tab' => 'Log Framework' 
            ],
            [   // CustomHTML
                'name'  => 'csa_framework_details',
                'type'  => 'custom_html',
                'value' => '<h6><b>The Action in the context of Climate-Smart Agriculture </b></h6>
                <p>The following questions will help us placing your activity within the general CSA landscape. </p>
                <p>The following categories are based on content from </p>
                <p><a href="https://csa.guide/">https://csa.guide/</a> and <a href="https://ccafs.cgiar.org/climate-smart-agriculture-0 ">https://ccafs.cgiar.org/climate-smart-agriculture-0 </a></p>
                <p>Please select the categories that apply to the action you are reporting </p>',
                'tab' => 'CSA Framework'
            ],
            [
                'type' => "relationship",
                'name' => 'pillars',
                'placeholder' => "Select Pillars",  
                'label' => 'To what of the following pillars of CSA does the reported effect contribute?',
                'hint' => 'You can select more than one ',
                'tab' => 'CSA Framework'
              
            ],
            [
                'type' => "relationship",
                'name' => 'practices',
                'placeholder' => "Select Practices",  
                'label' => 'Which of the entry points of the "Practices Thematic Area" are associated with the effect reported?',
                'hint' => 'You can select more than one ',
                'tab' => 'CSA Framework' 
            ],
            [
                'type' => "relationship",
                'name' => 'systems',
                'placeholder' => "Select Systems",  
                'label' => 'Which of the entry points of the "Systems approaches Thematic Area" are associated with the effect reported?',
                'hint' => 'You can select more than one ',
                'tab' => 'CSA Framework' 
            ],
            [
                'type' => "relationship",
                'name' => 'enable_envs',
                'placeholder' =>'Select Enabling environments Thematic Area',  
                'label' => 'Which of the entry points of the "Enabling environments Thematic Area" are associated with the effect reported?',
                'hint' => 'You can select more than one ',
                'tab' => 'CSA Framework'
            ],
            [
                'type' => "relationship",
                'name' => 'elements',
                'placeholder' => "Select Elements",  
                'label' => 'What CSA main elements of CSA are included in this work? ',
                'hint' => 'You can select more than one ',
                'tab' => 'CSA Framework'   
            ],
            [
                'type' => "relationship",
                'name' => 'main_actions',
                'placeholder' => "Select Main Actions",  
                'label' => 'To what of the major actions needed to implement CSA is this effect likely to contribute? ',
                'hint' => 'You can select more than one ',
                'tab' => 'CSA Framework'
            ],
            [
                'type' => "relationship",
                'name' => 'investments',
                'placeholder' => "Select Investments",  
                'label' => 'What CSA "areas of investment" are part of this work?',
                'hint' => 'You can select more than one ',
                'tab' => 'CSA Framework'
            ],
        ]);

        $this->crud->addSaveAction([
            'name' => 'save_action_and_next',
            'redirect' => function($crud, $request, $itemId) {
                if($request->current_tab != 'csa-framework'){
                  
                    $next_tabs = ['action'=>'details-of-the-action', 
                    'details-of-the-action'=>'products-generated', 
                    'products-generated'=>'log-framework', 
                    'log-framework'=>'csa-framework'];
                    return $crud->route."/".$itemId."/edit#".$next_tabs[$request->current_tab];
                
                }else{
                    return $crud->route;
                }
             
            }, // what's the redirect URL, where the user will be taken after saving?
        
            // OPTIONAL:
            'button_text' => 'Save and Next', // override text appearing on the button
            // You can also provide translatable texts, for example:
            // 'button_text' => trans('backpack::crud.save_action_one'),
            'visible' => function($crud) {
                return true;
            }, // customize when this save action is visible for the current operation
            'referrer_url' => function($crud, $request, $itemId) {
               
                return $crud->route;
            }, // override http_referrer_url
            // 'order' => 1, // change the order save actions are in
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

    public function store()
    {

        // do something before validation, before save, before everything
        $this->crud->getRequest()->request->remove('activities');
        $this->crud->getRequest()->request->remove('outputs');

        $response = $this->traitStore();

        // do something after save
        return $response;
        
    }

    public function getOutputs()
    {
        return Output::get()->pluck('name','id');
    }

    public function fetchEffects()
    {
        return $this->fetch(Effect::class);
    }

    public function fetchActivity()
    {
        $form = collect(request()->input('form'))->pluck('value', 'name');
       
        return $this->fetch([
            'model' => Activity::class,
            'query' => function ($model) use($form) {
                return $model->where('output_id', '=', $form['outputs']);
                }
        ]);
    }

    public function fetchSubactivities()
    {
        $form = collect(request()->input('form'))->pluck('value', 'name');
       
        return $this->fetch([
            'model' => Subactivity::class,
            'query' => function ($model) use($form) {
                return $model->where('activity_id', '=', $form['activities[]']);
                }
        ]);
    }

    public function fetchMilestones()
    {
        return $this->fetch(Milestone::class);
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

    protected function setupInlineCreateOperation()
    {
        $this->crud->removeAllFields();
      
        CRUD::addFields([ 
            [   // CustomHTML
                'name'  => 'separator',
                'type'  => 'custom_html',
                'value' => '<h6><b>The "Action" that produced the effect </b></h6>
                <p>In the next section you will describe the action in more detail: the objective, the affected agents, and details about its scope 

                This will allow us to build a landscape of the actions and those affected. This picture will be overlaid on the project Logframe and the frameworks that describe Climate Smart Agriculture.
                Please be detailed in the description of objectives, effects and agents affected. The information you provide will be useful only if there is evidence that backs it up. </p>
                '
            ],
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
                'label'         => 'When did the action that cause the effect start? ',
                'type'          => 'date',
                'hint'          => "if you don't know the exact date, the month and year are enough"
            ],
            [
                'name'          => 'end',
                'label'         => 'If the action has finished, please state the date ',
                'type'          => 'date',
                'hint'          => "if you don't know the exact date, the month and year are enough"
            ],
            [
                'type' => "hidden",
                'name' => 'completed',
                'value' => '0'
            ],
        ]);
            
    }
}
