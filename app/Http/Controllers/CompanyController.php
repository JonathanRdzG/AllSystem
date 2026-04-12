<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends BaseCrudController
{
    protected string $modelClass = Company::class;
    protected string $page = 'Companies';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'legal_name' => ['nullable', 'string', 'max:180'],
            'tax_id' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:40'],
            'active' => ['boolean'],
        ];
    }
}
