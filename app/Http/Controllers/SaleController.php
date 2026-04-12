<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Quote;
use App\Models\Sale;
use App\Models\User;

class SaleController extends BaseCrudController
{
    protected string $modelClass = Sale::class;
    protected string $page = 'Sales';

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'quote_id' => ['nullable', 'exists:quotes,id'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'string'],
            'sale_date' => ['required', 'date'],
            'total' => ['required', 'numeric'],
        ];
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->get(),
            'branches' => Branch::query()->select('id', 'name')->get(),
            'customers' => Customer::query()->select('id', 'name')->get(),
            'quotes' => Quote::query()->select('id')->get(),
            'users' => User::query()->select('id', 'name')->get(),
            'statuses' => ['draft', 'paid', 'partial', 'cancelled'],
        ];
    }
}
