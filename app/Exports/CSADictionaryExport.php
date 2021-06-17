<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;

class CSADictionaryExport implements FromCollection, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function title(): string
    {
        return ' CSADictionary';
    }

    public function collection()
    {
        return new Collection([
            ['group', 'column_header','refers to question'],

            ['pillar', 'CSA pillar Sustainability', 'Sustainably increasing agricultural productivity, to support equitable increases in farm incomes, food security and development;',],
            ['pillar', 'CSA pillar Adpating', 'Adapting and building resilience of agricultural and food security systems to climate change at multiple levels; and',],
            ['pillar', 'CSA pillar Reducing', 'Reducing greenhouse gas emissions from agriculture (including crops, livestock and fisheries).',],

            ['system', 'CSA system Value chains', 'Value chains',],
            ['system', 'CSA system Landscape management', 'Landscape management',],

            ['practices', 'CSA practices Energy management', 'Energy management',],
            ['practices', 'CSA practices Capture fisheries', 'Capture fisheries and aquaculture',],
            ['practices', 'CSA practices Forestry and agroforestry', 'Forestry and agroforestry',],
            ['practices', 'CSA practices Livestock management', 'Livestock management',],
            ['practices', 'CSA practices Water management', 'Water management',],
            ['practices', 'CSA practices Crop production', 'Crop production',],
            ['practices', 'CSA practices Soil management', 'Soil management',],

            ['elements', 'CSA elements Services for farmers', 'Services for farmers and land managers to enable them to implement the necessary changes',],
            ['elements', 'CSA elements Ecosystem', 'Ecosystem and landscape management to conserve ecosystem services that are key to increase at the same time resource efficiency and resilience',],
            ['elements', 'CSA elements Management of farms', 'Management of farms, crops, livestock, aquaculture and capture fisheries to manage resources better, produce more with less while increasing resilience',],

             
            ['investments', 'CSA investments Exploiting opportunities', 'Exploiting opportunities for reducing or removing greenhouse gas emissions where feasible.',],
            ['investments', 'CSA investments Understanding and planning', 'Understanding and planning for adaptive transitions that may be needed, for example into new farming systems or livelihoods, ',],
            ['investments', 'CSA investments Managing climate risks', 'Managing climate risks',],

            ['main actions', 'CSA main actions Enhancing financing', 'Enhancing financing options to support implementation, linking climate and agricultural finance',],
            ['main actions', 'CSA main actions Strengthening national', 'Strengthening national and local institutions to enable farmer management of climate risks and adoption of context-suitable agricultural practices, technologies and systems',],
            ['main actions', 'CSA main actions Building policy frameworks', 'Building policy frameworks and consensus to support implementation at scale',],
            ['main actions', 'CSA main actions Expanding the evidence', 'Expanding the evidence base and assessment tools to identify agricultural growth strategies for food security that integrate necessary adaptation and potential mitigation',],

            ['enable envs', 'CSA enable envs Gender and social inclusion.', 'Gender and social inclusion',],
            ['enable envs', 'CSA enable envs Institutional arrangements.', 'Institutional arrangements',],
            ['enable envs', 'CSA enable envs Policy engagement.', 'Policy engagement',],
            ['enable envs', 'CSA enable envs Infrastructure.', 'Infrastructure',],
            ['enable envs', 'CSA enable envs Climate information services.', 'Climate information services',],
            ['enable envs', 'CSA enable envs Index-based insurance.', 'Index-based insurance',],
         
        
        ]);
    }
}
