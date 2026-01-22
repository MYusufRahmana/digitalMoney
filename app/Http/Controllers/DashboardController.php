<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Hitung total saldo (pemasukan - pengeluaran)
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        $totalBalance = $totalIncome - $totalExpense;

        // Hitung pemasukan dan pengeluaran bulan ini
        $currentMonth = now()->format('Y-m');

        $monthlyIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereRaw("DATE_FORMAT(transaction_date, '%Y-%m') = ?", [$currentMonth])
            ->sum('amount');

        $monthlyExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereRaw("DATE_FORMAT(transaction_date, '%Y-%m') = ?", [$currentMonth])
            ->sum('amount');

        // Get 5 transaksi terbaru
        $recentTransactions = Transaction::where('user_id', $userId)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalBalance',
            'totalIncome',
            'totalExpense',
            'monthlyIncome',
            'monthlyExpense',
            'recentTransactions'
        ));
    }
}
