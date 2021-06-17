<?php

namespace App\Exports;

use App\Models\Subactivity;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SubActivitiesExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Subactivity::all();
    }

     /**
     * @return string
     */
    public function title(): string
    {
        return 'SubActivities';
    }

    public function map($value) : array
    {
        return [
            $value->id,
            $value->activity_id,
            $value->name,
           
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'activity_id',
            'name'
        ];
    }
}
