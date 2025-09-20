<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIpRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'title'           => ['required','string','max:255'],
            'application_no'  => ['nullable','string','max:255'],
            'type'            => ['required','string','max:100'],
            'status'          => ['nullable','string','max:100'],
            'applicant_name'  => ['nullable','string','max:255'],
            'faculty'         => ['nullable','string','max:255'],
            'research_title'  => ['nullable','string','max:255'],
            'budget_year'     => ['nullable','integer','between:2400,2700'], // รองรับ พ.ศ.
            'funding_source'  => ['nullable','string','max:255'],
            'submitter_name'  => ['nullable','string','max:255'],
            'certificate_no'  => ['nullable','string','max:255'],
            'certificate'     => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:8192'],
            'remark'          => ['nullable','string'],
            'is_published'    => ['sometimes','boolean'],
        ];
    }
}
