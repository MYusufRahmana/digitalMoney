<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Ambil user dengan query langsung
        $userId = Auth::id();

        // Get semua akun user yang aktif
        $accounts = Account::where('user_id', $userId)
            ->where('is_active', true)
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        // Get riwayat transaksi dengan pagination
        $transactions = Transaction::where('user_id', $userId)
            ->with('account')
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung total saldo per jenis akun
        $totalDigital = Account::where('user_id', $userId)
            ->where('type', 'digital')
            ->sum('balance');

        $totalCash = Account::where('user_id', $userId)
            ->where('type', 'cash')
            ->sum('balance');

        $totalSaham = Account::where('user_id', $userId)
            ->where('type', 'saham')
            ->sum('balance');

        $totalLainnya = Account::where('user_id', $userId)
            ->where('type', 'lainnya')
            ->sum('balance');

        $totalBalance = Account::where('user_id', $userId)
            ->sum('balance');

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

        return view('dashboard', compact(
            'accounts',
            'transactions',
            'totalDigital',
            'totalCash',
            'totalSaham',
            'totalLainnya',
            'totalBalance',
            'monthlyIncome',
            'monthlyExpense'
        ));
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $validated['user_id'] = Auth::id();

        // Cek apakah akun milik user yang login
        $account = Account::where('id', $validated['account_id'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$account) {
            return back()->withErrors([
                'account_id' => 'Akun tidak ditemukan atau bukan milik Anda.'
            ]);
        }

        Transaction::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function destroyTransaction(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    public function updateTransaction(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $account = Account::where('id', $validated['account_id'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$account) {
            return back()->withErrors([
                'account_id' => 'Akun tidak ditemukan atau bukan milik Anda.'
            ]);
        }

        $transaction->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Transaksi berhasil diupdate!');
    }
}
