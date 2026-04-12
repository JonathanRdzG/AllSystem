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

        $company = Company::create(['name' => 'Demo PyME', 'legal_name' => 'Demo PyME SA de CV', 'tax_id' => 'DPM010101AB1', 'email' => 'admin@demo.local', 'active' => true]);

        $branchA = Branch::create(['company_id' => $company->id, 'name' => 'Matriz', 'code' => 'MTZ', 'address' => 'Centro 100']);
        $branchB = Branch::create(['company_id' => $company->id, 'name' => 'Sucursal Norte', 'code' => 'NOR', 'address' => 'Av Norte 22']);

        foreach (['core', 'crm', 'quotes', 'sales', 'inventory', 'services'] as $module) {
            ModuleSubscription::create(['company_id' => $company->id, 'module_key' => $module, 'active' => true]);
        }

        $admin = User::create([
            'company_id' => $company->id,
            'branch_id' => $branchA->id,
            'name' => 'Admin Demo',
            'email' => 'admin@demo.local',
            'password' => Hash::make('password123'),
            'active' => true,
        ]);
        $admin->assignRole($adminRole);

        $operator = User::create([
            'company_id' => $company->id,
            'branch_id' => $branchB->id,
            'name' => 'Operador Demo',
            'email' => 'operador@demo.local',
            'password' => Hash::make('password123'),
            'active' => true,
        ]);
        $operator->assignRole($operatorRole);

        $customerA = Customer::create(['company_id' => $company->id, 'branch_id' => $branchA->id, 'name' => 'Cliente Uno', 'tax_id' => 'CUO010101AAA', 'email' => 'cliente1@demo.local']);
        $customerB = Customer::create(['company_id' => $company->id, 'branch_id' => $branchB->id, 'name' => 'Cliente Dos', 'tax_id' => 'CDO010101BBB', 'email' => 'cliente2@demo.local']);

        $category = Category::create(['company_id' => $company->id, 'name' => 'Refacciones']);
        $unit = Unit::create(['company_id' => $company->id, 'name' => 'Pieza', 'symbol' => 'pz']);

        $productA = Product::create(['company_id' => $company->id, 'category_id' => $category->id, 'unit_id' => $unit->id, 'sku' => 'PROD-001', 'name' => 'Batería 12V', 'cost' => 550, 'price' => 780]);
        $productB = Product::create(['company_id' => $company->id, 'category_id' => $category->id, 'unit_id' => $unit->id, 'sku' => 'PROD-002', 'name' => 'Cableado', 'cost' => 120, 'price' => 190]);

        $quote = Quote::create([
            'company_id' => $company->id,
            'branch_id' => $branchA->id,
            'customer_id' => $customerA->id,
            'user_id' => $admin->id,
            'status' => 'sent',
            'valid_until' => now()->addDays(15)->toDateString(),
            'total' => 970,
        ]);
        QuoteItem::create(['quote_id' => $quote->id, 'product_id' => $productA->id, 'description' => 'Batería 12V', 'quantity' => 1, 'unit_price' => 780, 'line_total' => 780]);
        QuoteItem::create(['quote_id' => $quote->id, 'product_id' => $productB->id, 'description' => 'Cableado', 'quantity' => 1, 'unit_price' => 190, 'line_total' => 190]);

        $sale = Sale::create([
            'company_id' => $company->id,
            'branch_id' => $branchA->id,
            'customer_id' => $customerA->id,
            'quote_id' => $quote->id,
            'user_id' => $admin->id,
            'status' => 'paid',
            'sale_date' => now()->toDateString(),
            'total' => 970,
        ]);
        SaleItem::create(['sale_id' => $sale->id, 'product_id' => $productA->id, 'description' => 'Batería 12V', 'quantity' => 1, 'unit_price' => 780, 'line_total' => 780]);

        $serviceOrder = ServiceOrder::create([
            'company_id' => $company->id,
            'branch_id' => $branchB->id,
            'customer_id' => $customerB->id,
            'assigned_user_id' => $operator->id,
            'status' => 'open',
            'title' => 'Revisión de instalación',
            'description' => 'Diagnóstico de falla eléctrica',
            'promise_date' => now()->addDays(3)->toDateString(),
            'comments' => 'Cliente requiere visita matutina',
        ]);

        $customerCustom = CustomFieldDefinition::create([
            'company_id' => $company->id,
            'entity_type' => CustomFieldEntity::Customer->value,
            'label' => 'Canal de adquisición',
            'internal_name' => 'acquisition_channel',
            'field_type' => 'select',
            'required' => false,
            'visible' => true,
            'editable' => true,
            'searchable' => true,
            'filterable' => true,
            'sort_order' => 1,
            'options_json' => ['web', 'referido', 'tienda'],
            'active' => true,
        ]);

        $serviceCustom = CustomFieldDefinition::create([
            'company_id' => $company->id,
            'entity_type' => CustomFieldEntity::ServiceOrder->value,
            'label' => 'Nivel de urgencia',
            'internal_name' => 'urgency_level',
            'field_type' => 'select',
            'required' => true,
            'visible' => true,
            'editable' => true,
            'searchable' => true,
            'filterable' => true,
            'sort_order' => 1,
            'options_json' => ['baja', 'media', 'alta'],
            'active' => true,
        ]);

        CustomFieldValue::create([
            'custom_field_definition_id' => $customerCustom->id,
            'entity_type' => CustomFieldEntity::Customer->value,
            'entity_id' => $customerA->id,
            'value' => 'web',
        ]);

        CustomFieldValue::create([
            'custom_field_definition_id' => $serviceCustom->id,
            'entity_type' => CustomFieldEntity::ServiceOrder->value,
            'entity_id' => $serviceOrder->id,
            'value' => 'media',
        ]);
    }
}
