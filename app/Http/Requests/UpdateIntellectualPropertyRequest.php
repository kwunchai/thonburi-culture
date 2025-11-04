<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\IntellectualProperty;
use Illuminate\Support\Facades\Auth;

class UpdateIntellectualPropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $ip = $this->route('ip');
        
        // User can update if they are the owner or an admin
        return auth()->check() && (
            $ip->owner_id === auth()->id() ||
            auth()->user()->hasRole('admin')
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $ipId = $this->route('ip')->ip_id;
        
        return [
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('intellectual_properties', 'title')->ignore($ipId, 'ip_id')
            ],
            'type' => [
                'sometimes',
                'required',
                'string',
                Rule::in(array_keys(IntellectualProperty::TYPES))
            ],
            'description' => [
                'sometimes',
                'required',
                'string',
                'min:10'
            ],
            'owner_id' => [
                'sometimes',
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
                Rule::unique('intellectual_properties', 'registration_number')->ignore($ipId, 'ip_id')
            ],
            'status' => [
                'sometimes',
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
            'attachments' => [
                'nullable',
                'array',
                'max:10'
            ],
            'attachments.*' => [
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:10240'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.unique' => 'ชื่อทรัพย์สินทางปัญญานี้มีอยู่ในระบบแล้ว',
            'type.in' => 'ประเภททรัพย์สินทางปัญญาไม่ถูกต้อง',
            'description.min' => 'คำอธิบายต้องมีอย่างน้อย 10 ตัวอักษร',
            'expiry_date.after' => 'วันหมดอายุต้องมากกว่าวันจดทะเบียน',
        ];
    }
}