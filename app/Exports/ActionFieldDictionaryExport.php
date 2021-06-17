<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class ActionFieldDictionaryExport implements FromCollection, WithTitle
{
    public function title(): string
    {
        return ' ActionFieldDictionary';
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection([
            ['group', 'column_header','refers to column'],

            ['scope', 'Scope Localised', 'Localised (boundaries known)',],
            ['scope', 'Scope Local plus', 'Local plus (spill over expected)',],
            ['scope', 'Scope Country wide', 'Country wide (one country)',],
            ['scope', 'Scope Multi-country', 'Multi-country',],
            ['scope', 'Scope Global', 'Global',],

            ['ipflow', 'Ipflow Basic', 'Basic, fundamental research /new knowledge generation',],
            ['ipflow', 'Ipflow Roll out', 'Roll out/implementation/adoption by intermediary or next users',],
            ['ipflow', 'Ipflow Dissemination', 'Dissemination/uptake by end users',],

        ]);
    }
}
