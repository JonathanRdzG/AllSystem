<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;

class BranchController extends BaseCrudController
{
    protected string $modelClass = Branch::class;
    protected string $page = 'Branches';
    protected array $with = ['company'];

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'name' => ['required', 'string', 'max:120'],
            'code' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'active' => ['boolean'],
        ];
    }

    protected function extraPayload(): array
    {
        return ['companies' => Company::query()->select('id', 'name')->get()];
    }
}
