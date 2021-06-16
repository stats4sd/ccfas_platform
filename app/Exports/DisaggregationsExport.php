<?php

namespace App\Exports;

use App\Models\Disaggregation;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class DisaggregationsExport implements FromCollection,  WithTitle, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Disaggregation::with(['indicatorValues'])->get();
    }

     /**
     * @return string
     */
    public function title(): string
    {
        return 'Disaggregations';
    }

    public function map($value) : array
    {
        return [
            $value->id,
            $value->name,
            $value->is_other ? 1 : '0',
        ];
    }

    public function headings(): array
    {
        return [
            'disaggregation_id',
            'disaggregation_name',
            'is_other',
        ];
    }
}
