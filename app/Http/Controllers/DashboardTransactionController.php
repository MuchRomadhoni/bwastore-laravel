<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])->whereHas('transaction', function ($transaction) {
            $transaction->where('users_id', Auth::user()->id);
        })->get();

        return view('pages.dashboard-transactions', [
            'buyTransactions' => $buyTransactions
        ]);
    }

    public function indexAdmin()
    {
        $sellTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])->whereHas('product', function ($product) {
            $product->where('users_id', Auth::user()->id);
        })->get();

        return view('pages.dashboard-transactions-sell', [
            'sellTransactions' => $sellTransactions
        ]);
    }

    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])->findOrFail($id);

        return view('pages.dashboard-transactions-details', [
            'transaction' => $transaction
        ]);
    }

    public function detailsAdmin(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])->findOrFail($id);

        return view('pages.dashboard-transactions-details-admin', [
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = TransactionDetail::findOrFail($id);

        $item->update($data);

        return redirect()->route('dashboard-transaction-details-admin', $id);
    }
}
