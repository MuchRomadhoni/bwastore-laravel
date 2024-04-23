<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\User;

use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {

        $transactions = TransactionDetail::with(['transaction.user', 'product.galleries'])->whereHas('product', function ($product) {
            $product->where('users_id', Auth::user()->id);
        });

        $revenue = $transactions->get()->reduce(function ($carry, $item) {
            return $carry + $item->price;
        });

        $customer = User::count();

        return view('pages.dashboard', [
            'transaction_count' => $transactions->count(),
            'transaction_data' => $transactions->get(),
            'revenue' => $revenue,
            'customer' => $customer
        ]);
    }

    public function indexUser()
    {
        $transactions =
            TransactionDetail::with(['transaction.user', 'product.galleries'])->whereHas('transaction', function ($transaction) {
                $transaction->where('users_id', Auth::user()->id);
            })->get();

        return view('pages.dashboard-user', [
            'transaction_count' => $transactions->count(),
            'transaction_data' => $transactions
        ]);
    }
}
