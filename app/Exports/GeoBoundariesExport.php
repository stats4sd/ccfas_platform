<?php

namespace App\Exports;

use App\Models\GeoBoundary;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class GeoBoundariesExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return GeoBoundary::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Geoboundaries';
    }

    public function map($value) : array
    {
        return [
            $value->id,
            $value->name,
            $value->country_ids,
            $value->country_names,
            $value->description,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'geo_boundary_name',
            'country_id',
            'country_name',
            'description',
        ];
    }

}
