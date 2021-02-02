<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')

    <label>{!! $field['label'] !!}</label>
    <input
        type="text"
        name="{{ $field['name'] }}"
        @include('crud::fields.inc.attributes')
        list="{{ $field['name'] }}"
        multiple
    >
    <datalist id="{{ $field['name'] }}">
    @foreach ($field['options'] as $key => $value)
        <option value="{{ $value }}"/>
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
    
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
 
    @push('crud_fields_scripts')
        <!-- no scripts -->
    @endpush
@endif