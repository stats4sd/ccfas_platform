<?php

namespace App\Exports;

use App\Models\Aim;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class AimsExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Aim::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return "Action's aims";
    }

    public function map($value) : array
    {
        foreach($value->actions as $action)
        {
            return [
                $action->id,
                $value->id,
                $value->name,
                $value->is_other ? 1 : '0',
               
            ];
        }
        return [];
    }

    public function headings(): array
    {
        return [
            'action_id',
            'aim_id',
            'aim_name',
            'is_other'
        ];
    }
}
