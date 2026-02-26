<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $customers = Transaction::query()
            ->selectRaw('
                user_id,
                COALESCE(customer_name, "") as customer_name,
                COALESCE(customer_phone, "") as customer_phone,
                COALESCE(customer_email, "") as customer_email,
                COUNT(*) as total_orders,
                SUM(grand_total) as total_spent,
                MAX(created_at) as last_order_at
            ')
            ->whereNotNull('user_id')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('customer_name', 'like', "%{$q}%")
                      ->orWhere('customer_phone', 'like', "%{$q}%")
                      ->orWhere('customer_email', 'like', "%{$q}%")
                      ->orWhere('order_id', 'like', "%{$q}%");
                });
            })
            ->groupBy('user_id', 'customer_name', 'customer_phone', 'customer_email')
            ->orderByDesc('last_order_at')
            ->paginate(10)
            ->withQueryString();

        return view('pages.customers.index', compact('customers', 'q'));
    }
}
