<?php

namespace App\Exports;

use App\Models\Output;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OutputsExport implements FromCollection,  WithTitle, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Output::all();
    }

     /**
     * @return string
     */
    public function title(): string
    {
        return 'Outputs';
    }

    public function map($value) : array
    {
        return [
            $value->id,
            $value->name,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'name'
        ];
    }
}
