<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightTargetRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        // 登録ステップ2（初期体重 + 目標体重）
        if ($this->routeIs('register.step2.store')) {
            return [
                'weight' => [
                    'required',
                    'numeric',
                    'max:9999.9',
                    'regex:/^\d{1,4}(\.\d)?$/',
                ],
                'target_weight' => [
                    'required',
                    'numeric',
                    'max:9999.9',
                    'regex:/^\d{1,4}(\.\d)?$/',
                ],
            ];
        }

        // 目標体重の更新
        if ($this->routeIs('goal.setting.update')) {
            return [
                'target_weight' => [
                    'required',
                    'numeric',
                    'max:9999.9',
                    'regex:/^\d{1,4}(\.\d)?$/',
                ],
            ];
        }

        // 体重ログ（通常）
        return [
            'weight' => [
                'required',
                'numeric',
                'max:9999.9',
                'regex:/^\d{1,4}(\.\d)?$/',
            ],
        ];
    }

    public function messages()
    {
        return [

            // 現在の体重
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数字で入力してください',
            'weight.max' => '4桁までの数字で入力してください',
            'weight.regex' => '小数点は1桁で入力してください',

            // 目標体重
            'target_weight.required' => '体重を入力してください',
            'target_weight.numeric' => '数字で入力してください',
            'target_weight.max' => '4桁までの数字で入力してください',
            'target_weight.regex' => '小数点は1桁で入力してください',

        ];
    }
}
