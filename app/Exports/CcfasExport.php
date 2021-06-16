<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CcfasExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    /**
    * @return array
    */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new DataDictionaryExport();
        $sheets[] = new EffectsExport();
        $sheets[] = new DisaggregationsExport();
        $sheets[] = new IndicatorValuesExport();
        $sheets[] = new EvidencesExport();
        $sheets[] = new BeneficiariesExport();
        $sheets[] = new ActionsExport();
        $sheets[] = new GeoBoundariesExport();
        $sheets[] = new ProductsExport();
        $sheets[] = new AimsExport();
        
        return $sheets;
    }
}
