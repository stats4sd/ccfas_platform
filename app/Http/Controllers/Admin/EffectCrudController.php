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
use Illuminate\Support\Facades\Redirect;

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
        $this->crud->addFilter(
            [
                'type'  => 'simple',
                'name'  => 'team_id',
                'label' => 'Team'
            ],
            false,
            function () {
                $teams = backpack_user()->teams;

                $this->crud->addClause('whereIn', 'team_id', $teams);
            }
        );

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
            // Backpack checks for upload==true fields before setting the form's enctype="multipart/form-data"
            // But it doesn't check 'fake' fields inside repeatable groups - so add a dummy_upload here to force the correct enctype;
            [
                'name' => 'dummy_upload',
                'upload' => true,
                'type' => 'hidden',
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
                        'name' => 'ind_value_id',
                        'type' => "hidden",
                        'value' => null

                    ],
                    [
                        'type' => "relationship",
                        'name' => 'indicators',
                        'ajax' => true,
                        'minimum_input_length' => 0,
                        'inline_create' => [ 'entity' => 'indicator' ],
                        'placeholder' => "Select an Indicator",
                        'label' =>'I.1 Select the indicator from the list. If it does not exist yet, please click on “+ Other” to add it.',
                        'multiple'=>false
                    ],
                    [
                        'name'    => 'value_qualitative',
                        'type'    => 'text',
                        'label'   => 'I.2 If the indicator you have chosen is qualitative, please describe that changes captures the size of effect you are reporting. This is how the indicator “changed” from its original condition',

                    ],
                    [
                        'name'    => 'baseline_qualitative',
                        'type'   =>'text',
                        'label' => 'I.2.1 If you have a baseline for this qualitative indicator, what was its status at baseline?<p></p>',


                    ],
                    [   // CustomHTML
                        'name'  => 'separator',
                        'type'  => 'custom_html',
                        'value' => '<hr style="border: 1px solid #384c74;">'
                    ],
                    [
                        'name'    => 'value_quantitative',
                        'type'    => 'number',
                        'label'   => 'I.3 If the indicator you have chosen is quantitative, please indicate the size of the effect in numbers in the box below. This is how much has the indicator “changed” from its original value',


                    ],

                    [
                        'name'    => 'baseline_quantitative',
                        'type'   =>'number',
                        'label' => 'I.3.1 If you have a baseline for this indicator, what was its value at baseline? What is the value of the indicator now?',


                    ],
                    [
                        'name' => 'effect_indicator_id',
                        'type' => "hidden",
                        'value' => null

                    ],
                    [
                        'name'    => 'ind_url_source',
                        'type'    => 'text',
                        'label'   => 'I.4 What was the source for this estimate of the indicator?
                        <p>I.4.1 Please provide a source that can be referenced. If it is on-line, please provide a URL.</p>',

                    ],
                    [   // Upload
                        'name'      => 'file_source',
                        'label'     => 'I.4.2 If you have a document that supports this indicator us evidence, you can upload it here.',
                        'type'      => 'upload',
                        'upload'    => true,
                        'disk'      => 'public',
                    ],
                    [
                        'name'    => 'level_attribution_id',
                        'type' => "select_from_array",
                        'label' => 'I.5 What is the level of attribution to the change in the indicator due to the work described?',

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
                        'type' => "select2_from_array",
                        'label' => 'I.6 If you can disaggregate this indicator, please indicate the criteria it can be disaggregated by',

                        // optional - force the related options to be a custom query, instead of all();
                        'options'   => $this->getDisaggregations(),
                        'allows_multiple' => true,
                        'allows_null' => true,

                    ]


                ],

                // optional
                'new_item_label'  => 'Add Indicator', // customize the text of the button

            ],
            [   // CustomHTML
                'name'  => 'separator',
                'type'  => 'custom_html',
                'value' => '<h6><b>Evidence</b></h6><p> Here you will enter any links (URLs) to supporting documents/sites for the evidence you have provided. If you need to add more than one link, press the "+" sign.</p>'
            ],


            [   // repeatable evidencies
                'name'  => 'evidences_repeat',
                'label' => '',
                'type'  => 'repeatable_with_upload',
                'value'=>null,
                'fields' => [
                    [
                        'name' => 'id',
                        'type' => "hidden",
                        'value' => null

                    ],
                    [
                        'name'    => 'description',
                        'type'    => 'text',
                        'label'   => 'E.1 Evidence desciption',
                    ],
                    [
                        'name'    => 'files_description',
                        'type'    => 'text',
                        'label'   => 'E.2 file desciption',

                    ],
                    [   // Upload
                        'name'      => 'evidence_files',
                        'label'     => 'E.3 Evidence Files',
                        'type'      => 'upload_multiple_for_repeatable',
                        'upload'    => true,
                        'disk'      => 'uploads', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
                    ],
                    [
                        'name'    => 'urls',
                        'type'    => 'url',
                        'label'   => 'E.4 Evidence url Source',

                    ],

                ],

                // optional
                'new_item_label'  => 'Add Evidence', // customize the text of the button

            ]
        ]);

        CRUD::addFields([

            [   // repeatable beneficiaries
                'name'  => 'beneficiaries_repeat',
                'label' => 'About the Beneficiaries',
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
                        'label' => 'B.1 Beneficiary type',
                        // 'allows_null' => true,

                        // optional - force the related options to be a custom query, instead of all();
                        'options'   => $this->getBeneficieryTypes(),

                    ],
                    [
                        'name'    => 'description',
                        'type'    => 'textarea',
                        'label'   => 'B.2 Benficiaries description',

                    ],

                ],

                // optional
                'new_item_label'  => 'Add Beneficiary', // customize the text of the button

            ],
            [   // CustomHTML
                'name'  => 'separator_action',
                'type'  => 'custom_html',
                'value' => '<hr style="border: 1px solid #384c74;">'
            ],
            [
                'name'  => 'action_label',
                'type'  => 'custom_html',
                'value' => '<h6><b>About the Action that generates the reported effect.</b></h6>
                <p>In the next section you will describe the action in more detail: the objective, the affected agents, and details about its scope

                This will allow us to build a landscape of the actions and those affected. This picture will be overlaid on the project Logframe and the frameworks that describe Climate Smart Agriculture.
                Please be detailed in the description of objectives, effects and agents affected. The information you provide will be useful only if there is evidence that backs it up.</p>
                <p>In the box below you can select an action that you have already escribed. If you want to describe a new action, please click on "+ Other"</p>

                <p>In this section you need to choose one of the following options</p>
                <ol type="1">
                    <li>If the action that is associated to the effect reported has already been described, choose it from the box below. </li>
                    <li>If the action has not yet been described click on the “+ Other” button and describe it.</li>
                </ol>
                <p>Remember that you can also edit the description of an action by going to the Action menu item on the left column and then click on “Edit” for the chosen action.</p>
                 '
            ],
            [
                'type' => "relationship",
                'name' => 'actions',
                'ajax' => true,
                'minimum_input_length' => 0,
                'inline_create' => [
                    'entity' => 'action',
                    'modal_class' => 'modal-dialog modal-xl',
                ],
                'placeholder' => "Select an Action",
                'label' =>'',
            ]
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
        return BeneficiaryType::get()->pluck('name', 'id');
    }

    public function getIndicators()
    {
        return Indicator::get()->pluck('name', 'id');
    }

    public function getLevelAttributions()
    {
        return LevelAttribution::get()->pluck('name', 'id');
    }

    public function getIndicatorStatus()
    {
        return IndicatorStatus::get()->pluck('name', 'id');
    }

    public function getDisaggregations()
    {
        return Disaggregation::get()->pluck('name', 'id');
    }

    public function store(EffectRequest $request)
    {

        // do something before validation, before save, before everything

        $response = $this->traitStore();
        $effect = $this->crud->getCurrentEntry();

        $this->updateOrCreateIndicators($request->indicator_repeat, $effect->id);
        $this->updateOrCreateEvidences($request->evidences_repeat, $effect->id);
        $this->updateOrCreateBeneficiaries($request->beneficiaries_repeat, $effect->id);

        // do something after save
        return $response;
    }

    public function update(EffectRequest $request)
    {
        // do something before validation, before save, before everything

        $response = $this->traitUpdate();
        $effect = $this->crud->getCurrentEntry();

        $this->updateOrCreateIndicators($request->indicator_repeat, $effect->id);
        $this->updateOrCreateEvidences($request->evidences_repeat, $effect->id);
        $this->updateOrCreateBeneficiaries($request->beneficiaries_repeat, $effect->id);

        // do something after save
        return $response;
    }

    public function updateOrCreateIndicators($repeat, $effect_id)
    {
        $indicators_repeat = json_decode($repeat);

        foreach ($indicators_repeat as $indicator) {
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
            $dis_name = "disaggregation_id[]";


            $indicator_value = IndicatorValue::updateOrCreate(
                [
                    'id'=> $indicator->ind_value_id,
                ],
                [
                    'link_effect_indicator_id' => $effect_indicator->id,
                    'value_qualitative' => $indicator->value_qualitative,
                    'value_quantitative' => $indicator->value_quantitative,
                    'url_source' => $indicator->ind_url_source,
                    'file_source' => $indicator->file_source,
                    'disaggregation_id'=> $indicator->$dis_name
                ]
            );

            $indicator_value->save();
        }
    }

    public function updateOrCreateBeneficiaries($repeat, $effect_id)
    {
        $beneficiaries_repeat = json_decode($repeat);

        foreach ($beneficiaries_repeat as $beneficiary) {
            //problem with file
            if (!empty($beneficiary->description)) {
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

    public function updateOrCreateEvidences($repeat, $effect_id)
    {
        $evidence_repeat = json_decode($repeat);

        foreach ($evidence_repeat as $index => $evidence) {
            //problem with file
            if (!empty($evidence->description)) {
                $new_evidence  = Evidence::updateOrCreate(
                    [
                        'id' => $evidence->id
                    ],
                    [
                        'effect_id' =>  $effect_id,
                        'description' => $evidence->description,
                        'files' => 'evidence_files_'.$index,
                        'urls' => $evidence->urls,
                        'files_description' => $evidence->files_description
                    ]
                );

                $new_evidence->save();
            }
        }
    }
}
