<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Quote;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Validation\Rule;

class SaleController extends BaseCrudController
{
    protected string $modelClass = Sale::class;
    protected string $page = 'Sales';
    protected array $with = ['company', 'branch', 'customer', 'quote', 'user'];
    protected array $search = ['status'];
    protected string $resourceName = 'venta';

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
            'quote_id' => [
                'nullable',
                Rule::exists('quotes', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'status' => ['required', Rule::in(['draft', 'paid', 'partial', 'cancelled'])],
            'sale_date' => ['required', 'date'],
            'total' => ['required', 'numeric', 'min:0'],
        ];
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->orderBy('name')->get(),
            'branches' => Branch::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'customers' => Customer::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'quotes' => Quote::query()
                ->select('id', 'company_id', 'customer_id', 'status', 'total')
                ->with('customer:id,name')
                ->latest('id')
                ->get(),
            'users' => User::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'statuses' => ['draft', 'paid', 'partial', 'cancelled'],
        ];
    }
}
