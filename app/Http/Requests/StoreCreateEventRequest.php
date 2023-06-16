<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $yesterday = date('Y-m-d', strtotime('-1 days'));

        return [
            'event_title' => ['required'],
            'event_description' => ['required'],
//            'event_date' => ['required', 'after:today'],
            'event_date' => ['required', "after:$yesterday"],

//            'start_time' => ['required'],
//            'end_time' => ['required'],
//            'adult_supervision' => ['required'],






        ];
    }
}
