<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ProductsExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return "Action's Products";
    }

    public function map($value) : array
    {
        foreach($value->actions as $action)
        {
            return [
                $action->id,
                $value->id,
                $value->product_type_id,
                $value->product_type->name,
                $value->audience,
                $value->audience_size,
                $value->publication,
                $value->distribution,
            ];
        }
        return [];
    }

    public function headings(): array
    {
        return [
            'action_id',
            'product_id',
            'product_type_id',
            'product_type_name',
            'audience',
            'audience_size',
            'publication',
            'distribution'
        ];
    }
}
