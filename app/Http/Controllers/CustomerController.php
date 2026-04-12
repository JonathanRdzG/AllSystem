<?php

namespace App\Http\Controllers;

use App\Enums\CustomFieldEntity;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CustomFieldDefinition;
use App\Models\CustomFieldValue;
use App\Models\Customer;
use App\Services\CustomFieldService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends BaseCrudController
{
    protected string $modelClass = Customer::class;
    protected string $page = 'Customers';

    public function __construct(private readonly CustomFieldService $customFieldService)
    {
    }

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'name' => ['required', 'string', 'max:120'],
            'tax_id' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:40'],
            'notes' => ['nullable', 'string'],
            'active' => ['boolean'],
        ] + $this->customFieldService->rules(CustomFieldEntity::Customer->value);
    }

    public function create(): Response
    {
        return Inertia::render('Customers/Create', $this->extraPayload());
    }

    public function edit(int $id): Response
    {
        $record = Customer::findOrFail($id);
        $customValues = CustomFieldValue::query()
            ->where('entity_type', CustomFieldEntity::Customer->value)
            ->where('entity_id', $id)
            ->with('definition')
            ->get();

        return Inertia::render('Customers/Edit', [
            'record' => $record,
            'customValues' => $customValues,
        ] + $this->extraPayload());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $customer = Customer::create(collect($data)->except('custom_fields')->all());
        $this->customFieldService->saveValues($customer, CustomFieldEntity::Customer->value, $data['custom_fields'] ?? []);

        return redirect()->route('customers.index');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $record = Customer::findOrFail($id);
        $record->update(collect($data)->except('custom_fields')->all());
        $this->customFieldService->saveValues($record, CustomFieldEntity::Customer->value, $data['custom_fields'] ?? []);

        return redirect()->route('customers.index');
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->get(),
            'branches' => Branch::query()->select('id', 'name')->get(),
            'customFields' => CustomFieldDefinition::query()->where('entity_type', CustomFieldEntity::Customer->value)->where('active', true)->orderBy('sort_order')->get(),
        ];
    }
}
