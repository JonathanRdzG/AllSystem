<?php

namespace App\Http\Controllers;

use App\Enums\CustomFieldEntity;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CustomFieldDefinition;
use App\Models\Customer;
use App\Models\ServiceOrder;
use App\Models\User;
use App\Services\CustomFieldService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceOrderController extends BaseCrudController
{
    protected string $modelClass = ServiceOrder::class;
    protected string $page = 'ServiceOrders';

    public function __construct(private readonly CustomFieldService $customFieldService)
    {
    }

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'assigned_user_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'string'],
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'promise_date' => ['nullable', 'date'],
            'comments' => ['nullable', 'string'],
            'checklist_json' => ['nullable', 'array'],
        ] + $this->customFieldService->rules(CustomFieldEntity::ServiceOrder->value);
    }

    public function create(): Response
    {
        return Inertia::render('ServiceOrders/Create', $this->extraPayload());
    }

    public function edit(int $id): Response
    {
        return Inertia::render('ServiceOrders/Edit', ['record' => ServiceOrder::findOrFail($id)] + $this->extraPayload());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $record = ServiceOrder::create(collect($data)->except('custom_fields')->all());
        $this->customFieldService->saveValues($record, CustomFieldEntity::ServiceOrder->value, $data['custom_fields'] ?? []);
        return redirect()->route('service-orders.index');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $record = ServiceOrder::findOrFail($id);
        $record->update(collect($data)->except('custom_fields')->all());
        $this->customFieldService->saveValues($record, CustomFieldEntity::ServiceOrder->value, $data['custom_fields'] ?? []);
        return redirect()->route('service-orders.index');
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->get(),
            'branches' => Branch::query()->select('id', 'name')->get(),
            'customers' => Customer::query()->select('id', 'name')->get(),
            'users' => User::query()->select('id', 'name')->get(),
            'customFields' => CustomFieldDefinition::query()->where('entity_type', CustomFieldEntity::ServiceOrder->value)->where('active', true)->orderBy('sort_order')->get(),
            'statuses' => ['open', 'in_progress', 'done', 'cancelled'],
        ];
    }
}
