<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Validation\Rule;

class QuoteController extends BaseCrudController
{
    protected string $modelClass = Quote::class;
    protected string $page = 'Quotes';
    protected array $with = ['company', 'branch', 'customer', 'user'];
    protected array $search = ['status'];
    protected string $resourceName = 'cotización';

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'branch_id' => [
                'required',
                Rule::exists('branches', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'status' => ['required', Rule::in(['draft', 'sent', 'approved', 'rejected'])],
            'valid_until' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'total' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->orderBy('name')->get(),
            'branches' => Branch::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'customers' => Customer::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'users' => User::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'statuses' => ['draft', 'sent', 'approved', 'rejected'],
        ];
    }
}
