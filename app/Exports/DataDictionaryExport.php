<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataDictionaryExport implements FromCollection, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return new Collection([
            ['sheet', 'column_header','refers to question'],

            ['Sites', 'id', 'The Site ID from the database - used for linking to Interviews',],
            ['', '', '1. Site Name and Location'],
            ['Sites', 'name', 'The Site name', ],
            ['Sites', 'boundaries', 'A GIS layer file with the outline of the study site', ],
            ['Sites', 'location', 'The approximate location', ],

            ['', '', '2. Agricultural Context'],
            ['', '', 'General Area'],
            ['Sites', 'agro_ecozone', 'General area - Agro-ecozone', ],
            ['Sites', 'dominant_agricultural', 'Dominant agricultural systems', ],
            ['Sites', 'trends_in_agriculture', 'Trends in agriculture', ],
            ['Sites', 'policies_influencing_trends', 'Policies influencing trends', ],

            ['', '', 'Specific Project Site'],
            ['Sites', 'position_of_agroecology', ' Position of agroecology', ],
            ['Sites', 'topography', ' Topography', ],
            ['Sites', 'land_use_and_history', ' Landuse and history', ],
            ['Sites', 'typical_farm_size', ' Typical farm size', ],
            ['Sites', 'typical_land_tenure', ' Typical land tenure', ],
            ['Sites', 'role_of_livestock', ' Role of livestock', ],
            ['Sites', 'employment_and_local_economy', ' Employment and local economy', ],
            ['Sites', 'trends_last_10_years', ' Trends in the above over the last 10 years', ],

            ['', '', 'Basic Info and raw data files'],
            ['', '', 'Interview Details'],
            ['Basic Info', 'id', 'The Interview ID - used to link to records from the other worksheets', ],
            ['Basic Info', 'site_id', 'The Site ID - used to link to the sites sheet', ],
            ['Basic Info', 'interviewer_name', 'The interviewer name', ],
            ['Basic Info', 'date', 'The date of the interview', ],
            ['Basic Info', 'location', 'The location of the interview', ],
            ['', '', 'Raw Data'],
            ['Basic Info', 'records', 'Audio recordings uploaded', ],
            ['Basic Info', 'scripts_original', 'Interview notes, transcripts etc uploaded - in the original language', ],
            ['Basic Info', 'scripts_english', 'English translation of the transcript', ],

            ['', '', 'Key Informant Details'],
            ['Key Informants', 'id', 'Key Informant ID',],
            ['Key Informants', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['Key Informants', 'name', 'Key informant name',],
            ['Key Informants', 'gender', 'Key informant gender',],
            ['Key Informants', 'role_in_agriculture', 'What is the role of the key informant in agriculture in the area?',],
            ['Key Informants', 'role_in_case_study', ' What is the role of key informant in the case study project?',],
            ['Key Informants', 'selection_criteria', 'Was this key informant selected for being part of any of the following groups?If yes, select the group. (If no, leave this field blank and enter the reasons for selection in the additional comments below)',],
            ['Key Informants', 'explain_criteria', ' Add any additional comments regarding why this key informant was selected.',],

            ['', '', 'Context'],
            ['', '', 'This section captures an overall description of the study context so that each Case Study can be characterised in the same terms. It includes a description of the role or prominence of "agroecology" in relevant dialogues.'],
            ['', '', 'Guiding Question: 1. Can you tell me about agriculture in the area?'],

            ['Context', 'id', 'Record ID',],
            ['Context', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['Context', 'main_agriculture_systems', ' What are the main types of agriculture?',],
            ['Context', 'trends_in_agriculture', ' How has agriculture changed in the last 2 decades?',],
            ['Context', 'policies_influencing_trends', ' Have any policies or programs influenced agricultural trends?',],
            ['Context', 'main_challenges_in_agriculture', ' What are some of the main challenges of agriculture?',],

            ['', '', 'Agroecology'],
            ['', '', 'This section positions the KI in terms of knowledge of and views on agroecology.',],
            ['', '', 'Guiding Question: 2. Now I would like to ask you specifically about agroecology.'],

            ['Agroecology', 'id', 'The record ID - used to link back to the database if needed.',],
            ['Agroecology', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['Agroecology', 'familiarity_with_agroecology', ' Are you familiar with agroecology? How would you describe or define it?',],
            ['Agroecology', 'role_of_agroecology_in_farms', ' Is it a common way to practice agriculture in this area? If yes, are there certain groups of people or regions where agroecology is more common?',],
            ['Agroecology', 'groups_promoting_agroecology', ' Are there certain groups or organizations which promote it? If yes, can you tell me more about them',],
            ['Agroecology', 'groups_against_agroecology', ' Are there certain groups or organizations which are against it? If yes, can you tell me more about them',],

            ['', '', 'Interventions'],
            ['', '', 'This section asks for a description of recent interventions that are the basis of the Case Study, together with their extent. It also asks about other interventions (from other sources) that have had an influence on farms in the region.'],
            ['', '', 'Guiding Question: 3. I would now like to ask about the project/program linked to the Case Study (), which has worked in this area. Can you describe the project? What was involved?'],
            ['', '', 'Guiding Question: 4. Have there been other interventions/projects/programs in the last 5 years that have had an important impact on farming in the location?', 'Note - Answers from questions 3 and 4 are presented together as a full set of interventions. They are distinguished by the "is_other" field, which shows if the intervention is part of this Case Study or a different intervention.'],

            ['Interventions', 'id', 'The record ID - used to link back to the database if needed.',],
            ['Interventions', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['Interventions', 'project', 'project',],
            ['Interventions', 'intervention_type', 'The Type of intervention',],
            ['Interventions', 'start_at', ' What year did the intevention start? ',],
            ['Interventions', 'end_at', ' What year did the intervention end? ',],
            ['Interventions', 'ongoing', 'Is the intervention ongoing?',],
            ['Interventions', 'percentage_farms_directly_involved', ' Roughly what percentage of farmers were directly involved? ',],
            ['Interventions', 'percentage_farms_directly_involved_comment', ' Space for comments about the value entered',],
            ['Interventions', 'percentage_farms_indirectly_affected', ' Roughly what percentage of farmers were indirectly involved? ',],
            ['Interventions', 'percentage_farms_indirectly_affected_comment', ' Space for comments about the value entered',],
            ['Interventions', 'interaction_with_farmers', ' What was the nature of the interaction with farmers?',],
            ['Interventions', 'is_other', 'Is this intervention part of a different program? (1 = Part of a different program, 0 = Part of this Case Study',],


            ['', '', 'Agroecology Practices'],
            ['', '', 'This section explores the AE practices known by the key informant to be part of the farms in the study area, whether or not promoted by the intervention.'],
            ['', '', 'Guiding Question: 5. Can you describe the main agroecological practices found in the farms here. These may be practices that have been used for a long time (conventional or traditional practices), practices introduced by the Case Study project (), or though other project and interventions. '],

            ['AE Practices', 'id', 'The record ID - used to link back to the database if needed.',],
            ['AE Practices', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['AE Practices', 'agroecology_practice', ' Briefly describe the practice. ',],
            ['AE Practices', 'percentage_long_term_or_recently', ' Estimate the percentage of farms using this practice before the interventions of this Case Study began. ',],
            ['AE Practices', 'percentage_long_term_or_recently_comment', ' Space for comments on this number. ',],
            ['AE Practices', 'percentage_introduced_by_CS', ' Estimate the percentage of farms who started using this practice in response to the interventions of this Case Study. ',],
            ['AE Practices', 'percentage_introduced_by_CS_comment', ' Space for comments on this number. ',],
            ['AE Practices', 'percentage_introduced_by_interventions', ' Estimate the percentage of farms who started using this practice in response to other interventions ',],
            ['AE Practices', 'percentage_introduced_by_interventions_comment', ' Space for comments on this number. ',],
            ['AE Practices', 'importance', 'How important is the practice? By "important", we mean the practice is influencing farmer\'s lives, not just being tried in small areas.',],

            ['', '', 'Guiding Question: 6. How are these agroecological practices used on the farm?'],
            ['AEPs How Used', 'id', 'The record ID - used to link back to the database if needed.',],
            ['AEPs How Used', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['AEPs How Used', 'agroecology_practice', ' Which practice(s) is this entry linked to? ',],
            ['AEPs How Used', 'used', ' How is/are the practice(s) used on the farm?',],
            ['AEPs How Used', 'what_replaced', ' Is it replacing something else, combined with something that was there, or used in addition to existing practices?',],
            ['AEPs How Used', 'material_input_used', ' What materials or inputs are used?',],


            ['Who is using the practices and why?'],
            ['', '', 'This section is an investigation of the variation between farmers in the use of the practices, and the characteristics of those users.'],
            ['', '', 'Guiding Question: 7. We know farmers are not all the same and only some will use a particular practice. For the practices we have been discussing, can you describe the characteristics of the people who use it, and why they use it? Can you also describe who does not use it and why not?'],

            ['AEPs Who and Why', 'id', 'The record ID - used to link back to the database if needed.',],
            ['AEPs Who and Why', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['AEPs Who and Why', 'agroecology_practice', ' Which practice(s) is this entry linked to? ',],
            ['AEPs Who and Why', 'who_use', ' Can you describe the characteristics of the people who use the practice(s)?',],
            ['AEPs Who and Why', 'why_use', ' Can you describe why they use the practice(s)?',],
            ['AEPs Who and Why', 'who_dont_use', ' Can you describe the characteristics of the people who do not use the practice(s)?',],
            ['AEPs Who and Why', 'who_dont_use', ' Can you describe why they do not use the practice(s)?',],

            ['Effects, benefits or implications of using the practices'],
            ['', '', 'This section explores the implications or impacts, positive or negative, of using the practices, both on the farms and individual livelihoods and on the landscape or community.'],
            ['', '', 'Guiding question: 8. Thinking of each practice in turn, what - in general terms - are the effects on a farm or farmer of using it, compared with alternative practices? Are there also effects on the larger landscape or community?'],

            ['AEPs Effects', 'id', 'The record ID - used to link back to the database if needed.',],
            ['AEPs Effects', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['AEPs Effects', 'agroecology_practice', ' Which practice(s) does this entry refer to? ',],
            ['AEPs Effects', 'social_users', ' What are the social effects on a farm or farmer of using it, compared with alternative practices?',],
            ['AEPs Effects', 'economic_users', ' What are the economic effects on a farm or farmer of using it, compared with alternative practices?',],
            ['AEPs Effects', 'environmental_users', ' What are the environmental effects on a farm or farmer of using it, compared with alternative practices?',],
            ['AEPs Effects', 'social_community', ' What are the social effects on a larger landscape or community compared with alternative practices?',],
            ['AEPs Effects', 'economic_community', ' What are the economic effects on a larger landscape or community compared with alternative practices?',],
            ['AEPs Effects', 'environmental_community', ' What are the environmental effects on a larger landscape or community compared with alternative practices',],


            ['', '', 'Guiding question: 9. Please describe the labour involved in using each practice, compared with the labour requirements of the alternatives.'],
            ['AEPs Labour', 'id', 'The record ID - used to link back to the database if needed.',],
            ['AEPs Labour', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['AEPs Labour', 'agroecology_practice', ' Which practice(s) does this entry refer to? ',],
            ['AEPs Labour', 'labour_required', ' Does the practice reduce or increase labour compared to alternatives?',],
            ['AEPs Labour', 'returns_to_labour', ' Is the labour worth while for the effect produced?',],
            ['AEPs Labour', 'labour_affected', ' Whose labour is affected?',],
            ['AEPs Labour', 'other_consequences_of_labour_used', 'If this practice has different labour requirements than the alternative, what else does that affect? (Other consequences of the labour used)'],

            ['', '', 'Anything Else'],
            ['', '', 'This section is an opportunity to pass on other information the key informant thinks is relevant.', '', '',],
            ['', '', 'Guiding Question: 10. Is there anything else we should know about agroecology in the area?'],
            ['Anything Else', 'id', 'The record ID - used to link back to the database if needed.',],
            ['Anything Else', 'ki_interview_id', 'The interview ID - used to link back to the basic info worksheet',],
            ['Anything Else', 'description', ' Enter comments here.',],
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $wrap = [
            'alignment' => [
                'wrapText' => true
            ],
        ];

        $h1 = [
            'font' => ['bold' => true, 'size' => 22],
        ];

        $h2 = [
            'font' => ['bold' => true, 'size' => 16],
        ];

        $qu = [
            'font' => [
                'size' => 13,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '48A18E'],
            ]
        ];

        return [
            'C' => $wrap,
            'D' => $wrap,

            1 => $h2,
            // Site Name and Location
            3 => $h1,

            // Agricultural Context
            7 => $h1,

            // Basic Info
            22 => $h1,
            23 => $h2,
            29 => $h2,

            // Key Informant Details
            33 => $h1,


            // Context
            42 => $h1,
            43 => $qu,
            44 => $qu,

            // Agroecology
            51 => $h1,
            52 => $qu,
            53 => $qu,

            // Interventions
            60 => $h1,
            61 => $qu,
            62 => $qu,
            63 => $qu,

            // Agroecology Practices
            77 => $h1,
            78 => $qu,
            79 => $qu,

            // How are the AEPs used?
            90 => $qu,

            // Who is using the practice and why?
            97 => $h1,
            98 => $qu,
            99 => $qu,


            //Effects + Benefits
            107 => $h1,
            108 => $qu,
            109 => $qu,

            // Anything Else
            127 => $h1,
            128 => $qu,
            129 => $qu,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 25,
            'C' => 50,
            'D' => 50,
        ];
    }
}
