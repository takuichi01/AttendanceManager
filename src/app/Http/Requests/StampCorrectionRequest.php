<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StampCorrectionRequest extends FormRequest
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
            'remarks' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'remarks.required' => '備考を記入してください',
        ];
    }

    public function withValidator($validator) {
        // 勤務時間の開始と終了の整合性チェック
        $validator->after(function ($validator) {
            $workStartInput = $this->input('work_start_time');
            $workEndInput = $this->input('work_end_time');
            $breakStartInputs = $this->input('break_start_time', []);
            $breakEndInputs = $this->input('break_end_time', []);
            $addBreakStartInputs = $this->input('add_break_start_time');
            $addBreakEndInputs = $this->input('add_break_end_time');

            $workStartTime = $workStartInput ? \Carbon\Carbon::createFromFormat('H:i', $workStartInput) : null;
            $workEndTime = $workEndInput ? \Carbon\Carbon::createFromFormat('H:i', $workEndInput) : null;
            $addBreakStartTime = $addBreakStartInputs ? \Carbon\Carbon::createFromFormat('H:i', $addBreakStartInputs) : null;
            $addBreakEndTime = $addBreakEndInputs ? \Carbon\Carbon::createFromFormat('H:i', $addBreakEndInputs) : null;

            if ($workStartTime && $workEndTime && $workStartTime->gt($workEndTime)) {
                $validator->errors()->add('work_time', '出勤時間もしくは退勤時間が不適切な値です');
            }
            
            foreach ($breakStartInputs as $i => $breakStart) {
                $breakStartTime = $breakStart ? \Carbon\Carbon::createFromFormat('H:i', $breakStart) : null;
                if ($workStartTime && $workEndTime && $breakStartTime && ( $breakStartTime->lt($workStartTime) || $breakStartTime->gt($workEndTime) )) {
                    $validator->errors()->add("break_start_time.$i", '休憩時間が不適切な値です');
                }
            }
            foreach ($breakEndInputs as $i => $breakEnd) {
                $breakEndTime = $breakEnd ? \Carbon\Carbon::createFromFormat('H:i', $breakEnd) : null;
                if ($workEndTime && $breakEndTime &&  $breakEndTime->gt($workEndTime)) {
                    $validator->errors()->add("break_end_time.$i", '休憩時間もしくは退勤時間が不適切な値です');
                }
            }

            if ($workStartTime && $workEndTime && $addBreakStartTime && ( $addBreakStartTime->lt($workStartTime) || $addBreakStartTime->gt($workEndTime) )) {
                $validator->errors()->add('add_break_start_time', '休憩時間が不適切な値です');
            }

            if ($workEndTime && $addBreakEndTime &&  $addBreakEndTime->gt($workEndTime)) {
                $validator->errors()->add('add_break_end_time', '休憩時間もしくは退勤時間が不適切な値です');
            }
        });
    }
}
