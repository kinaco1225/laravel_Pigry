<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightLogRequest extends FormRequest
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
        return [
            // 1. 日付
            'date' => ['required'],

            // 2. 体重
            'weight' => [
                'required',
                'numeric',
                'max:9999',
                'regex:/^\d+(\.\d{1})?$/',
            ],

            // 3. 摂取カロリー
            'calories' => [
                'required',
                'numeric',
            ],

            // 4. 運動時間（分）
            'exercise_time' => ['required'],

            // 5. 運動内容
            'exercise_content' => [
                'nullable',
                'string',
                'max:120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // 日付
            'date.required' => '日付を入力してください',

            // 体重
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数字で入力してください',
            'weight.max' => '4桁までの数字で入力してください',
            'weight.regex' => '小数点は1桁で入力してください',

            // 摂取カロリー
            'calories.required' => '摂取カロリーを入力してください',
            'calories.numeric' => '数字で入力してください',

            // 運動時間
            'exercise_time.required' => '運動時間を入力してください',

            // 運動内容
            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }
}
