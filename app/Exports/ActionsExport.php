<?php

namespace App\Exports;

use App\Models\Action;
use App\Models\LinkEffectAction;
use CreateLinkEffectsActionsTable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ActionsExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LinkEffectAction::all();
    }
     /**
     * @return string
     */
    public function title(): string
    {
        return 'Actions';
    }

    public function map($value) : array
    {
        $action = Action::findOrFail($value->action_id);
      
            return [
                $value->effect_id,
                $value->action_id,
                $action->description,
                $action->start,
                $action->end,
                $action->geo_boundary_id,
                $action->subactivities_numbers,
                $action->activities_numbers,
                $action->outputs_numbers,
                $action->milestones_numbers,
                $action->pillar_sustainability,
                $action->pillar_adpating,
                $action->pillar_reducing,
                $action->system_action_chains,
                $action->system_landscape_management,
                $action->practices_energy_management,
                $action->capture_fisheries,
                $action->forestry_agroforestry,
                $action->livestock_management,
                $action->water_management,
                $action->crop_production,
                $action->soil_management,
                $action->services_for_farmers,
                $action->ecosystem,
                $action->management_of_farms,
                $action->exploiting_opportunities,
                $action->understanding_and_planning,
                $action->managing_climate_risks,
                $action->enhancing_financing,
                $action->strengthening_national,
                $action->building_policy_frameworks,
                $action->expanding_evidence,
                $action->gender,
                $action->institutional_arrangements,
                $action->policy_engagement,
                $action->infrastructure,
                $action->climate_information_services,
                $action->index_based_insurance,

                $action->scope_localised,
                $action->scope_local_plus,
                $action->country_wide,
                $action->multi_country,
                $action->global,

                $action->basic,
                $action->roll_out,
                $action->dissemination,
            ];
        
    }

    public function headings(): array
    {
        return [
            'effect_id',
            'action_id',
            'description',
            'start',
            'end',
            'geoboundary_id',
            'subactivities',
            'activities',
            'output',
            'milestones',
            'CSA pillar Sustainability',
            'CSA pillar Adpating',
            'CSA pillar Reducing',
            'CSA system Value chains',
            'CSA system Landscape management',
            'CSA practices Energy management',
            'CSA practices Capture fisheries',
            'CSA practices Forestry and agroforestry',
            'CSA practices Livestock management',
            'CSA practices Water management',
            'CSA practices Crop production',
            'CSA practices Soil management',
            'CSA elements Services for farmers',
            'CSA elements Ecosystem',
            'CSA elements Management of farms',
            'CSA investments Exploiting opportunities',
            'CSA investments Understanding and planning',
            'CSA investments Managing climate risks',
            'CSA main actions Enhancing financing',
            'CSA main actions Strengthening national',
            'CSA main actions Building policy frameworks',
            'CSA main actions Expanding the evidence',
            'CSA enable envs Gender and social inclusion.',
            'CSA enable envs Institutional arrangements.',
            'CSA enable envs Policy engagement.',
            'CSA enable envs Infrastructure.',
            'CSA enable envs Climate information services.',
            'CSA enable envs Index-based insurance.',

            'Scope Localised',
            'Scope Local plus',
            'Scope Country wide',
            'Scope Multi-country',
            'Scope Global',

            'Ipflow Basic',
            'Ipflow Roll out',
            'Ipflow Dissemination',

        ];
    }
}
