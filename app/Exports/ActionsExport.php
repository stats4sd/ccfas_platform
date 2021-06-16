<?php

namespace App\Exports;

use App\Models\Action;
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
        $query = Action::with(['effects'])->get();
        // dd($query);
        
        return Action::with(['effects'])->get();
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

        foreach($value->effects as $effect)
        {
            return [
                $effect->id,
                $value->id,
                $value->description,
                $value->start,
                $value->end,
                $value->geo_boundary_id,
                $value->subactivities_numbers,
                $value->activities_numbers,
                $value->outputs_numbers,
                $value->milestones_numbers,
                $value->pillar_sustainability,
                $value->pillar_adpating,
                $value->pillar_reducing,
                $value->system_value_chains,
                $value->system_landscape_management,
                $value->practices_energy_management,
                $value->capture_fisheries,
                $value->forestry_agroforestry,
                $value->livestock_management,
                $value->water_management,
                $value->crop_production,
                $value->soil_management,
                $value->services_for_farmers,
                $value->ecosystem,
                $value->management_of_farms,
                $value->exploiting_opportunities,
                $value->understanding_and_planning,
                $value->managing_climate_risks,
                $value->enhancing_financing,
                $value->strengthening_national,
                $value->building_policy_frameworks,
                $value->expanding_evidence,
                $value->gender,
                $value->institutional_arrangements,
                $value->policy_engagement,
                $value->infrastructure,
                $value->climate_information_services,
                $value->index_based_insurance,

                $value->scope_localised,
                $value->scope_local_plus,
                $value->country_wide,
                $value->multi_country,
                $value->global,

                $value->basic,
                $value->roll_out,
                $value->dissemination,
            ];
        }
        return [];
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
