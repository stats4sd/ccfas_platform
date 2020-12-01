<!-- select2 multiple -->
@php
    if (!isset($field['options'])) {
        if(isset($field['tagType'])) {
            $options = $field['model']::withType($field['tagType'])->get();
        }
        else {
            $options = $field['model']::all();
        }
    } else {
        $options = call_user_func($field['options'], $field['model']::query());
    }
    $multiple = isset($field['multiple']) && $field['multiple']===false ? '': 'multiple';


@endphp

@include('crud::fields.inc.wrapper_start')
    <div class="">
        <label>{!! $field['label'] !!}</label>
        @include('crud::fields.inc.translatable_icon')
    </div>
    <div class="">
        <select
            name="spatie_tags_{{$field['tagType']}}[]"
            style="width: 100%"
            data-tag-type="{{$field['tagType'] ?: NULL}}"
            data-init-function="bpFieldInitSelect2MultipleElement"
            data-select2-tags="{{ $field['select2Tags'] ?: 0}}"
            @include('crud::fields.inc.attributes', ['default_class' =>  'form-control select2_multiple'])
            {{$multiple}}>

            @if (isset($field['allows_null']) && $field['allows_null']==true)
                <option value="">-</option>
            @endif

            @if (isset($field['model']))
                @foreach ($options as $option)
                    @if(
                        (
                            old(square_brackets_to_dots($field["name"]))
                            && in_array($option->getKey(), old($field["name"]))
                        )
                        || (
                            is_null(old(square_brackets_to_dots($field["name"])))
                            && isset($entry)
                            && in_array($option->getKey(), $entry->tagsWithType($field['tagType'])->pluck('id','id')->toArray())
                            )
                        )
                        <option value="{{ $option->{$field['attribute']} }}" selected>{{ $option->{$field['attribute']} }}</option>
                    @else
                        <option value="{{ $option->{$field['attribute']} }}">{{ $option->{$field['attribute']} }}</option>
                    @endif
                @endforeach
            @endif
        </select>
        {{-- HINT --}}
        @if (isset($field['hint']))
            <p class="help-block">{!! $field['hint'] !!}</p>
        @endif

        @if(isset($field['select2Tags']) && $field['select2Tags'])
            <p class="help-block font-italic font-weight-light">New tags will be created on save.</p>
        @endif

        @if(isset($field['select_all']) && $field['select_all'])
            <a class="btn btn-xs btn-default select_all" style="margin-top: 5px;"><i class="la la-check-square-o"></i> {{ trans('backpack::crud.select_all') }}</a>
            <a class="btn btn-xs btn-default clear" style="margin-top: 5px;"><i class="la la-times"></i> {{ trans('backpack::crud.clear') }}</a>
        @endif
    </div>

@include('crud::fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include select2 css-->
        <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
        @if (app()->getLocale() !== 'en')
        <script src="{{ asset('packages/select2/dist/js/i18n/' . app()->getLocale() . '.js') }}"></script>
        @endif
        <script>
            function bpFieldInitSelect2MultipleElement(element) {
                if (!element.hasClass("select2-hidden-accessible"))
                {
                    var $obj = element.select2({
                        theme: "bootstrap",
                        tags: element.data('select2-tags'),
                    });

                    var options = [];
                    @if (count($options))
                        @foreach ($options as $option)
                            options.push({{ $option->getKey() }});
                        @endforeach
                    @endif

                    @if(isset($field['select_all']) && $field['select_all'])
                        element.parent().find('.clear').on("click", function () {
                            $obj.val([]).trigger("change");
                        });
                        element.parent().find('.select_all').on("click", function () {
                            $obj.val(options).trigger("change");
                        });
                    @endif
                }
            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
