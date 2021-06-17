<?php

namespace App\Exports;

use App\Models\IndicatorValue;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class IndicatorValuesExport implements FromCollection, WithTitle, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return IndicatorValue::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Indicator Values';
    }

    public function map($value) : array
    {
       
        return [
            $value->id,
            $value->linkEffectIndicator->effect_id,
            $value->linkEffectIndicator->indicator_id,
            $value->linkEffectIndicator->indicator->name,
            $value->value_quantitative,
            $value->linkEffectIndicator->baseline_quantitative,
            $value->value_qualitative,
            $value->linkEffectIndicator->baseline_qualitative,
            $value->url_source,
            $value->file_source,
            $value->linkEffectIndicator->levelAttribution->name,
            $value->disaggregation_id,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'effect_id',
            'indicator_id',
            'indicator_name',
            'indicator_value_quantitative',
            'indicator_baseline_quantitative',
            'indicator_value_qualitative',
            'indicator_baseline_qualitative',
            'url_source',
            'file_source',
            'level_attribution_name',
            'disaggregation_id'
        ];
    }
}
