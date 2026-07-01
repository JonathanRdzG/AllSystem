<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Validation\Rule;

class ProductController extends BaseCrudController
{
    protected string $modelClass = Product::class;
    protected string $page = 'Products';
    protected array $with = ['company', 'category', 'unit'];
    protected array $search = ['sku', 'name', 'description'];
    protected string $resourceName = 'producto';

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'unit_id' => [
                'required',
                Rule::exists('units', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'sku' => [
                'required',
                'string',
                'max:40',
                Rule::unique('products', 'sku')
                    ->where(fn ($query) => $query->where('company_id', request('company_id')))
                    ->ignore(request()->route('product')),
            ],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'cost' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'active' => ['nullable', 'boolean'],
        ];
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->orderBy('name')->get(),
            'categories' => Category::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'units' => Unit::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
        ];
    }
}
