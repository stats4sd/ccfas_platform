<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')

    <label>{!! $field['label'] !!}</label>
    <input
        list="options"
        name="{{ $field['name'] }}"
    

        selectBoxOptions= "{{ $field['options'] }}"
        @include('crud::fields.inc.attributes')
    >
    <datalist id="options">
    @foreach ($field['options'] as $key => $value)
        <option value="{{ $value }}"></option>
    @endforeach
 
</datalist>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- no styles -->
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- no scripts -->
    @endpush
@endif