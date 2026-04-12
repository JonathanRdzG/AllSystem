<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Unit;

class ProductController extends BaseCrudController
{
    protected string $modelClass = Product::class;
    protected string $page = 'Products';

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'sku' => ['required', 'string', 'max:40'],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'cost' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'active' => ['boolean'],
        ];
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->get(),
            'categories' => Category::query()->select('id', 'name')->get(),
            'units' => Unit::query()->select('id', 'name')->get(),
        ];
    }
}
