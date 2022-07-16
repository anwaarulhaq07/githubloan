<?php

namespace App\Http\Requests;

use App\Models\Mortage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMortageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mortage_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'loandamoutn' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'downpayment' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'percentage' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'loan_terms' => [
                'required',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
