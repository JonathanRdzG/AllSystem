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
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends BaseCrudController
{
    protected string $modelClass = Customer::class;
    protected string $page = 'Customers';
    protected array $with = ['company', 'branch'];
    protected array $search = ['name', 'tax_id', 'email', 'phone'];
    protected string $resourceName = 'cliente';

    public function __construct(private readonly CustomFieldService $customFieldService)
    {
    }

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
            'name' => ['required', 'string', 'max:120'],
            'tax_id' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'notes' => ['nullable', 'string'],
            'active' => ['nullable', 'boolean'],
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
            'customFieldValues' => $customValues
                ->mapWithKeys(fn (CustomFieldValue $value) => [
                    $value->definition->internal_name => $value->value,
                ]),
        ] + $this->extraPayload());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $customer = Customer::create(collect($data)->except('custom_fields')->all());
        $this->customFieldService->saveValues($customer, CustomFieldEntity::Customer->value, $data['custom_fields'] ?? []);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $record = Customer::findOrFail($id);
        $record->update(collect($data)->except('custom_fields')->all());
        $this->customFieldService->saveValues($record, CustomFieldEntity::Customer->value, $data['custom_fields'] ?? []);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->get(),
            'branches' => Branch::query()
                ->select('id', 'company_id', 'name')
                ->orderBy('name')
                ->get(),
            'customFields' => CustomFieldDefinition::query()
                ->where('entity_type', CustomFieldEntity::Customer->value)
                ->where('active', true)
                ->orderBy('sort_order')
                ->get(),
        ];
    }
}
