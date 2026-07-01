<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use Illuminate\Validation\Rule;

class BranchController extends BaseCrudController
{
    protected string $modelClass = Branch::class;
    protected string $page = 'Branches';
    protected array $with = ['company'];
    protected array $search = ['name', 'code', 'address', 'phone'];
    protected string $resourceName = 'sucursal';

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'name' => ['required', 'string', 'max:120'],
            'code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('branches', 'code')
                    ->where(fn ($query) => $query->where('company_id', request('company_id')))
                    ->ignore(request()->route('branch')),
            ],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'active' => ['nullable', 'boolean'],
        ];
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),
        ];
    }
}
