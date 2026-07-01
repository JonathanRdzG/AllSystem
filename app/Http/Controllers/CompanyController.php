<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends BaseCrudController
{
    protected string $modelClass = Company::class;
    protected string $page = 'Companies';
    protected array $search = ['name', 'legal_name', 'tax_id', 'email', 'phone'];
    protected string $resourceName = 'empresa';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'legal_name' => ['nullable', 'string', 'max:180'],
            'tax_id' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
