<?php

namespace App\Exports;

use App\Models\Team;
use App\Models\Effect;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class EffectsExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Effect::with(['team'])->get();

    
        return $query;
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Effects';
    }

    public function map($value) : array
    {
        return [
            $value->id,
            $value->team_id,
            $value->team->name,
            $value->description,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'team_id',
            'team_name',
            'description',
        ];
    }

    

}
