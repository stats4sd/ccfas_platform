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

class EffectsExport implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles
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
            'effect_id',
            'team_id',
            'team_name',
            'description',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $wrap = [
            'alignment' => [
                'wrapText' => true
            ],
        ];

        $h1 = [
            'font' => ['bold' => true, 'size' => 22],
        ];

        $h3 = [
            'font' => ['bold' => true, 'size' => 14],
        ];

        $qu = [
            'font' => [
                'size' => 13,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '48A18E'],
            ]
        ];

        return [
            // 'C' => $wrap,
            // 'D' => $wrap,

            1 => $h3,
            // // Site Name and Location
            // 3 => $h1,

            // // Agricultural Context
            // 7 => $h1,

            // // Basic Info
            // 22 => $h1,
            // 23 => $h2,
            // 29 => $h2,

            // // Key Informant Details
            // 33 => $h1,


            // // Context
            // 42 => $h1,
            // 43 => $qu,
            // 44 => $qu,

            // // Agroecology
            // 51 => $h1,
            // 52 => $qu,
            // 53 => $qu,

            // // Interventions
            // 60 => $h1,
            // 61 => $qu,
            // 62 => $qu,
            // 63 => $qu,

            // // Agroecology Practices
            // 77 => $h1,
            // 78 => $qu,
            // 79 => $qu,

            // // How are the AEPs used?
            // 90 => $qu,

            // // Who is using the practice and why?
            // 97 => $h1,
            // 98 => $qu,
            // 99 => $qu,


            // //Effects + Benefits
            // 107 => $h1,
            // 108 => $qu,
            // 109 => $qu,

            // // Anything Else
            // 127 => $h1,
            // 128 => $qu,
            // 129 => $qu,
        ];
    }

}
