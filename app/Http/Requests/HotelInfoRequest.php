<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HotelInfoRequest extends FormRequest
{
    public function failedValidation($validator)
    {
        $error = $validator->errors()->first();

        $response = response()->json([
            'code' => -1,
            'msg'  => $error,
            'data' => $validator->errors(),
        ]);

        throw new HttpResponseException($response);
    }

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
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'integer|required',
            'account' => 'required',
            'bank' => 'required',
            'bank_account' => 'required',
            'bank_province' => 'required',
            'bank_city' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '请选择账户性质',
            'account.required' => '请填写账户名称',
            'bank.required' => '请填写开户行',
            'bank_account.required' => '参数错误',
            'bank_province.required' => '参数错误',
            'bank_city.required' => '参数错误',
        ];
    }
}
