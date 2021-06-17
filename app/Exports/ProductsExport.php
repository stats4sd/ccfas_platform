<?php

namespace App\Exports;

use App\Models\LinkActionProduct;
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
        return LinkActionProduct::all();
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
        $product = Product::findOrFail($value->product_id);
       
            return [
                $value->action_id,
                $value->product_id,
                $product->product_type_id,
                $product->product_type->name,
                $product->audience,
                $product->audience_size,
                $product->publication,
                $product->distribution,
            ];
        
     
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
