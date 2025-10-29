<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\IntellectualProperty;
use Illuminate\Support\Facades\Auth;

class StoreIntellectualPropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'unique:intellectual_properties,title'
            ],
            'type' => [
                'required',
                'string',
                Rule::in(array_keys(IntellectualProperty::TYPES))
            ],
            'description' => [
                'required',
                'string',
                'min:10'
            ],
            'owner_id' => [
                'nullable',
                'integer',
                'exists:users,id'
            ],
            'registration_date' => [
                'nullable',
                'date',
                'before_or_equal:today'
            ],
            'registration_number' => [
                'nullable',
                'string',
                'max:100',
                'unique:intellectual_properties,registration_number'
            ],
            'status' => [
                'nullable',
                'string',
                Rule::in(array_keys(IntellectualProperty::STATUSES))
            ],
            'expiry_date' => [
                'nullable',
                'date',
                'after:registration_date'
            ],
            'metadata' => [
                'nullable',
                'array'
            ],
            'metadata.*.key' => [
                'required_with:metadata',
                'string'
            ],
            'metadata.*.value' => [
                'required_with:metadata'
            ],
            'attachments' => [
                'nullable',
                'array',
                'max:10'
            ],
            'attachments.*' => [
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:10240' // 10MB
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'กรุณาระบุชื่อทรัพย์สินทางปัญญา',
            'title.unique' => 'ชื่อทรัพย์สินทางปัญญานี้มีอยู่ในระบบแล้ว',
            'type.required' => 'กรุณาเลือกประเภททรัพย์สินทางปัญญา',
            'type.in' => 'ประเภททรัพย์สินทางปัญญาไม่ถูกต้อง',
            'description.required' => 'กรุณาระบุคำอธิบาย',
            'description.min' => 'คำอธิบายต้องมีอย่างน้อย 10 ตัวอักษร',
            'registration_date.before_or_equal' => 'วันที่จดทะเบียนต้องไม่เกินวันปัจจุบัน',
            'expiry_date.after' => 'วันหมดอายุต้องมากกว่าวันจดทะเบียน',
            'attachments.*.max' => 'ขนาดไฟล์ต้องไม่เกิน 10MB',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('status') && is_null($this->status)) {
            $this->merge(['status' => 'draft']);
        }
    }
}