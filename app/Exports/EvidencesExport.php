<?php

namespace App\Exports;

use App\Models\Evidence;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class EvidencesExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Evidence::all();
    }
    
     /**
     * @return string
     */
    public function title(): string
    {
        return 'Evidences';
    }

    public function map($value) : array
    {
        return [
            $value->effect_id,
            $value->id,
            $value->description,
            $value->files_description,
            $value->urls,
        ];
    }

    public function headings(): array
    {
        return [
            'effect_id',
            'id',
            'description',
            'files_description',
            'url',
        ];
    }
}
