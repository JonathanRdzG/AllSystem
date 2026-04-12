<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Sale;
use App\Models\ServiceOrder;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'customers' => Customer::count(),
                'products' => Product::count(),
                'quotes' => Quote::count(),
                'sales' => Sale::count(),
                'serviceOrders' => ServiceOrder::count(),
            ],
        ]);
    }
}
