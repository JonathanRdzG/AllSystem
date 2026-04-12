<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldDefinition extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'entity_type', 'label', 'internal_name', 'field_type',
        'required', 'visible', 'editable', 'searchable', 'filterable',
        'default_value', 'help_text', 'sort_order', 'options_json', 'active'
    ];

    protected function casts(): array
    {
        return [
            'required' => 'boolean',
            'visible' => 'boolean',
            'editable' => 'boolean',
            'searchable' => 'boolean',
            'filterable' => 'boolean',
            'active' => 'boolean',
            'options_json' => 'array',
        ];
    }
}
