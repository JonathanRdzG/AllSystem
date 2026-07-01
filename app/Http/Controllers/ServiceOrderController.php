<?php

namespace App\Http\Controllers;

use App\Enums\CustomFieldEntity;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CustomFieldDefinition;
use App\Models\CustomFieldValue;
use App\Models\Customer;
use App\Models\ServiceOrder;
use App\Models\User;
use App\Services\CustomFieldService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ServiceOrderController extends BaseCrudController
{
    protected string $modelClass = ServiceOrder::class;
    protected string $page = 'ServiceOrders';
    protected array $with = ['company', 'branch', 'customer', 'assignedUser'];
    protected array $search = ['status', 'title', 'description', 'comments'];
    protected string $resourceName = 'orden de servicio';

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
            'customer_id' => [
                'required',
                Rule::exists('customers', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'assigned_user_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'status' => ['required', Rule::in(['open', 'in_progress', 'done', 'cancelled'])],
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
        $customValues = CustomFieldValue::query()
            ->where('entity_type', CustomFieldEntity::ServiceOrder->value)
            ->where('entity_id', $id)
            ->with('definition')
            ->get();

        return Inertia::render('ServiceOrders/Edit', [
            'record' => ServiceOrder::findOrFail($id),
            'customFieldValues' => $customValues
                ->mapWithKeys(fn (CustomFieldValue $value) => [
                    $value->definition->internal_name => $value->value,
                ]),
        ] + $this->extraPayload());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $record = ServiceOrder::create(collect($data)->except('custom_fields')->all());
        $this->customFieldService->saveValues($record, CustomFieldEntity::ServiceOrder->value, $data['custom_fields'] ?? []);

        return redirect()
            ->route('service-orders.index')
            ->with('success', 'Orden de servicio creada correctamente.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $record = ServiceOrder::findOrFail($id);
        $record->update(collect($data)->except('custom_fields')->all());
        $this->customFieldService->saveValues($record, CustomFieldEntity::ServiceOrder->value, $data['custom_fields'] ?? []);

        return redirect()
            ->route('service-orders.index')
            ->with('success', 'Orden de servicio actualizada correctamente.');
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->orderBy('name')->get(),
            'branches' => Branch::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'customers' => Customer::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'users' => User::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
            'customFields' => CustomFieldDefinition::query()->where('entity_type', CustomFieldEntity::ServiceOrder->value)->where('active', true)->orderBy('sort_order')->get(),
            'statuses' => ['open', 'in_progress', 'done', 'cancelled'],
        ];
    }
}
