<?php

use App\Enums\CustomFieldEntity;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CustomFieldDefinition;
use App\Models\CustomFieldValue;
use App\Models\User;

it('persists customer custom field values', function () {
    $company = Company::factory()->create();
    $branch = Branch::factory()->create(['company_id' => $company->id]);
    $user = User::factory()->create(['company_id' => $company->id, 'branch_id' => $branch->id]);

    CustomFieldDefinition::create([
        'company_id' => $company->id,
        'entity_type' => CustomFieldEntity::Customer->value,
        'label' => 'Origen',
        'internal_name' => 'origin',
        'field_type' => 'text',
        'required' => false,
        'visible' => true,
        'editable' => true,
        'searchable' => false,
        'filterable' => false,
        'sort_order' => 1,
        'active' => true,
    ]);

    $payload = [
        'company_id' => $company->id,
        'branch_id' => $branch->id,
        'name' => 'Cliente Test',
        'active' => true,
        'custom_fields' => ['origin' => 'Facebook'],
    ];

    $this->actingAs($user)->post('/customers', $payload)->assertRedirect('/customers');

    expect(CustomFieldValue::query()->where('entity_type', CustomFieldEntity::Customer->value)->where('value', 'Facebook')->exists())->toBeTrue();
});
