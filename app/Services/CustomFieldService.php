<?php

namespace App\Services;

use App\Models\CustomFieldDefinition;
use App\Models\CustomFieldValue;
use Illuminate\Database\Eloquent\Model;

class CustomFieldService
{
    public function rules(string $entityType): array
    {
        $definitions = CustomFieldDefinition::query()
            ->where('entity_type', $entityType)
            ->where('active', true)
            ->orderBy('sort_order')
            ->get();

        $rules = [];

        foreach ($definitions as $definition) {
            $key = 'custom_fields.'.$definition->internal_name;
            $fieldRules = [];

            if ($definition->required) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            $fieldRules[] = match ($definition->field_type) {
                'text', 'textarea', 'select', 'user_select', 'branch_select', 'customer_select' => 'string',
                'integer' => 'integer',
                'decimal' => 'numeric',
                'date' => 'date',
                'boolean' => 'boolean',
                default => 'string',
            };

            $rules[$key] = $fieldRules;
        }

        return $rules;
    }

    public function saveValues(Model $entity, string $entityType, array $payload): void
    {
        $definitions = CustomFieldDefinition::query()
            ->where('entity_type', $entityType)
            ->where('active', true)
            ->get()
            ->keyBy('internal_name');

        foreach ($payload as $internalName => $value) {
            if (! $definitions->has($internalName)) {
                continue;
            }

            $definition = $definitions[$internalName];

            CustomFieldValue::query()->updateOrCreate(
                [
                    'custom_field_definition_id' => $definition->id,
                    'entity_type' => $entityType,
                    'entity_id' => $entity->getKey(),
                ],
                [
                    'value' => is_array($value) ? json_encode($value) : (string) $value,
                ]
            );
        }
    }
}
