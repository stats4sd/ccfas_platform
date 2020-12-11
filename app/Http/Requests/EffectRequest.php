<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EffectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team_id' => 'required',
            'description' => 'required',
            // 'indicator_repeat'      => function ($attribute, $value, $fail) {
            //     $fieldGroups = json_decode($value);

            //     // do not allow repeatable field to be empty
            //     if (count($fieldGroups) == 0) {
            //         return $fail('The indicator field group must have at least one item.');
            //     }

            //     // ALTERNATIVE:
            //     // allow repeatable field to be empty
            //     // if (count($fieldGroups) == 0) {
            //     //   return true;
            //     // }

            //     // SECOND-LEVEL REPEATABLE VALIDATION
            //     // run through each field group inside the repeatable field
            //     // and run a custom validation for it
            //     foreach ($fieldGroups as $key => $group) {
            //         $fieldGroupValidator = Validator::make((array) $group, [
            //             // 'level_attribution_id'  => 'required',

            //         ]);

            //         if ($fieldGroupValidator->fails()) {
            //             // return $fail('One of the entries in the '.$attribute.' group is invalid.');
            //             // alternatively, you could just output the first error
            //             return $fail($fieldGroupValidator->errors()->first());
            //             // or you could use this to debug the errors
            //                 // dd($fieldGroupValidator->errors());
            //         }
            //     }
            // },
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
