<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DashboardTransactionController extends Controller
{
    // public function index()
    // {
    //     $sellTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
    //                         ->whereHas('product', function($product){
    //                             $product->where('users_id', Auth::user()->id);
    //                         })->get();
    //     $buyTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
    //                         ->whereHas('transaction', function($transaction){
    //                             $transaction->where('users_id', Auth::user()->id);
    //                         })->get();

    //     return view('pages.dashboard-transactions',[
    //         'sellTransactions' => $sellTransactions,
    //         'buyTransactions' => $buyTransactions
    //     ]);
    // }
    public function index()
    {
        if (request()->ajax()) {
            $query = Transaction::with(['user'])->where('users_id', Auth::user()->id);

            return DataTables::of($query)
                ->editColumn('total_price', function ($item) {
                    return 'Rp ' . number_format($item->total_price);
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                    type="button" id="action' .  $item->id . '"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '">
                                    <a class="dropdown-item" href="' . route('dashboard-transaction-details', $item->id) . '">
                                        Detail
                                    </a>
                                </div>
                            </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard-transactions');
    }

    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->findOrFail($id);
        return view('pages.dashboard-transactions-details', [
            'transaction' => $transaction
        ]);
    }

    // public function update(Request $request, $id)
    // {
    //     $data = $request->all();

    //     $item = TransactionDetail::findOrFail($id);

    //     $item->update($data);

    //     return redirect()->route('dashboard-transaction-details', $id);
    // }
}
