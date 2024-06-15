<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Transaction;
use App\TransactionDetail;

class DashboardController extends Controller
{
    public function index()
    {
        $recentTransaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->latest()
            ->get();

        $customer = User::where('roles', 'USER')->count();
        $revenue = Transaction::sum('total_price');
        $transaction = Transaction::count();

        return view('pages.admin.dashboard', [
            'recentTransaction' => $recentTransaction,
            'customer' => $customer,
            'revenue' => $revenue,
            'transaction' => $transaction
        ]);
    }
}
