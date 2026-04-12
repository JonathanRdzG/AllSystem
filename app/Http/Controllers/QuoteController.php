<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Quote;
use App\Models\User;

class QuoteController extends BaseCrudController
{
    protected string $modelClass = Quote::class;
    protected string $page = 'Quotes';

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'string'],
            'valid_until' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'total' => ['required', 'numeric'],
        ];
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->get(),
            'branches' => Branch::query()->select('id', 'name')->get(),
            'customers' => Customer::query()->select('id', 'name')->get(),
            'users' => User::query()->select('id', 'name')->get(),
            'statuses' => ['draft', 'sent', 'approved', 'rejected'],
        ];
    }
}
