<?php

namespace Database\Seeders;

use App\Enums\CustomFieldEntity;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Company;
use App\Models\CustomFieldDefinition;
use App\Models\CustomFieldValue;
use App\Models\Customer;
use App\Models\ModuleSubscription;
use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\ServiceOrder;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage companies', 'manage branches', 'manage users', 'manage customers',
            'manage products', 'manage quotes', 'manage sales', 'manage service_orders'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $operatorRole = Role::firstOrCreate(['name' => 'operator', 'guard_name' => 'web']);

        $adminRole->syncPermissions($permissions);
        $operatorRole->syncPermissions(['manage customers', 'manage quotes', 'manage service_orders']);

        $company = Company::query()->updateOrCreate(
            ['tax_id' => 'DPM010101AB1'],
            ['name' => 'Demo PyME', 'legal_name' => 'Demo PyME SA de CV', 'email' => 'admin@demo.local', 'active' => true]
        );

        $branchA = Branch::query()->updateOrCreate(
            ['company_id' => $company->id, 'code' => 'MTZ'],
            ['name' => 'Matriz', 'address' => 'Centro 100', 'active' => true]
        );
        $branchB = Branch::query()->updateOrCreate(
            ['company_id' => $company->id, 'code' => 'NOR'],
            ['name' => 'Sucursal Norte', 'address' => 'Av Norte 22', 'active' => true]
        );

        foreach (['core', 'crm', 'quotes', 'sales', 'inventory', 'services'] as $module) {
            ModuleSubscription::query()->updateOrCreate(
                ['company_id' => $company->id, 'module_key' => $module],
                ['active' => true]
            );
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@demo.local'],
            [
                'company_id' => $company->id,
                'branch_id' => $branchA->id,
                'name' => 'Admin Demo',
                'password' => Hash::make('password123'),
                'active' => true,
            ]
        );
        $admin->assignRole($adminRole);

        $operator = User::query()->updateOrCreate(
            ['email' => 'operador@demo.local'],
            [
                'company_id' => $company->id,
                'branch_id' => $branchB->id,
                'name' => 'Operador Demo',
                'password' => Hash::make('password123'),
                'active' => true,
            ]
        );
        $operator->assignRole($operatorRole);

        $customerA = Customer::query()->updateOrCreate(
            ['company_id' => $company->id, 'email' => 'cliente1@demo.local'],
            ['branch_id' => $branchA->id, 'name' => 'Cliente Uno', 'tax_id' => 'CUO010101AAA', 'active' => true]
        );
        $customerB = Customer::query()->updateOrCreate(
            ['company_id' => $company->id, 'email' => 'cliente2@demo.local'],
            ['branch_id' => $branchB->id, 'name' => 'Cliente Dos', 'tax_id' => 'CDO010101BBB', 'active' => true]
        );

        $category = Category::query()->updateOrCreate(
            ['company_id' => $company->id, 'name' => 'Refacciones'],
            ['active' => true]
        );
        $unit = Unit::query()->updateOrCreate(
            ['company_id' => $company->id, 'name' => 'Pieza'],
            ['symbol' => 'pz', 'active' => true]
        );

        $productA = Product::query()->updateOrCreate(
            ['company_id' => $company->id, 'sku' => 'PROD-001'],
            ['category_id' => $category->id, 'unit_id' => $unit->id, 'name' => 'Batería 12V', 'cost' => 550, 'price' => 780, 'active' => true]
        );
        $productB = Product::query()->updateOrCreate(
            ['company_id' => $company->id, 'sku' => 'PROD-002'],
            ['category_id' => $category->id, 'unit_id' => $unit->id, 'name' => 'Cableado', 'cost' => 120, 'price' => 190, 'active' => true]
        );

        $quote = Quote::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'branch_id' => $branchA->id,
                'customer_id' => $customerA->id,
                'user_id' => $admin->id,
                'status' => 'sent',
            ],
            [
                'valid_until' => now()->addDays(15)->toDateString(),
                'total' => 970,
            ]
        );
        QuoteItem::query()->updateOrCreate(
            ['quote_id' => $quote->id, 'description' => 'Batería 12V'],
            ['product_id' => $productA->id, 'quantity' => 1, 'unit_price' => 780, 'line_total' => 780]
        );
        QuoteItem::query()->updateOrCreate(
            ['quote_id' => $quote->id, 'description' => 'Cableado'],
            ['product_id' => $productB->id, 'quantity' => 1, 'unit_price' => 190, 'line_total' => 190]
        );

        $sale = Sale::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'branch_id' => $branchA->id,
                'customer_id' => $customerA->id,
                'quote_id' => $quote->id,
                'user_id' => $admin->id,
            ],
            [
                'status' => 'paid',
                'sale_date' => now()->toDateString(),
                'total' => 970,
            ]
        );
        SaleItem::query()->updateOrCreate(
            ['sale_id' => $sale->id, 'description' => 'Batería 12V'],
            ['product_id' => $productA->id, 'quantity' => 1, 'unit_price' => 780, 'line_total' => 780]
        );

        $serviceOrder = ServiceOrder::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'customer_id' => $customerB->id,
                'title' => 'Revisión de instalación',
            ],
            [
                'branch_id' => $branchB->id,
                'assigned_user_id' => $operator->id,
                'status' => 'open',
                'description' => 'Diagnóstico de falla eléctrica',
                'promise_date' => now()->addDays(3)->toDateString(),
                'comments' => 'Cliente requiere visita matutina',
            ]
        );

        $customerCustom = CustomFieldDefinition::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'entity_type' => CustomFieldEntity::Customer->value,
                'internal_name' => 'acquisition_channel',
            ],
            [
                'label' => 'Canal de adquisición',
                'field_type' => 'select',
                'required' => false,
                'visible' => true,
                'editable' => true,
                'searchable' => true,
                'filterable' => true,
                'sort_order' => 1,
                'options_json' => ['web', 'referido', 'tienda'],
                'active' => true,
            ]
        );

        $serviceCustom = CustomFieldDefinition::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'entity_type' => CustomFieldEntity::ServiceOrder->value,
                'internal_name' => 'urgency_level',
            ],
            [
                'label' => 'Nivel de urgencia',
                'field_type' => 'select',
                'required' => true,
                'visible' => true,
                'editable' => true,
                'searchable' => true,
                'filterable' => true,
                'sort_order' => 1,
                'options_json' => ['baja', 'media', 'alta'],
                'active' => true,
            ]
        );

        CustomFieldValue::query()->updateOrCreate(
            [
                'custom_field_definition_id' => $customerCustom->id,
                'entity_type' => CustomFieldEntity::Customer->value,
                'entity_id' => $customerA->id,
            ],
            ['value' => 'web']
        );

        CustomFieldValue::query()->updateOrCreate(
            [
                'custom_field_definition_id' => $serviceCustom->id,
                'entity_type' => CustomFieldEntity::ServiceOrder->value,
                'entity_id' => $serviceOrder->id,
            ],
            ['value' => 'media']
        );
    }
}
