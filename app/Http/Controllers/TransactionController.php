<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Halaman kelola transaksi (dengan aksi edit/hapus)
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Transaction::where('user_id', $userId);

        // Filter berdasarkan type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter berdasarkan category
        if ($request->filled('category')) {
            $query->where('category', 'LIKE', '%' . $request->category . '%');
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Hitung total untuk summary
        $totalIncome = Transaction::where('user_id', $userId)
            ->when($request->filled('type'), function($q) use ($request) {
                return $q->where('type', $request->type);
            })
            ->when($request->filled('payment_method'), function($q) use ($request) {
                return $q->where('payment_method', $request->payment_method);
            })
            ->when($request->filled('category'), function($q) use ($request) {
                return $q->where('category', 'LIKE', '%' . $request->category . '%');
            })
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->when($request->filled('type'), function($q) use ($request) {
                return $q->where('type', $request->type);
            })
            ->when($request->filled('payment_method'), function($q) use ($request) {
                return $q->where('payment_method', $request->payment_method);
            })
            ->when($request->filled('category'), function($q) use ($request) {
                return $q->where('category', 'LIKE', '%' . $request->category . '%');
            })
            ->where('type', 'expense')
            ->sum('amount');

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense'));
    }

    /**
     * Halaman riwayat transaksi (read-only)
     */
    public function history(Request $request)
    {
        $userId = Auth::id();

        $query = Transaction::where('user_id', $userId);

        // Filter berdasarkan type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan periode
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('transaction_date', today());
                    break;
                case 'week':
                    $query->whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('transaction_date', now()->month)
                          ->whereYear('transaction_date', now()->year);
                    break;
                case 'year':
                    $query->whereYear('transaction_date', now()->year);
                    break;
            }
        }

        // Filter berdasarkan tanggal custom
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Hitung total untuk periode yang difilter
        $baseQuery = Transaction::where('user_id', $userId);

        if ($request->filled('type')) {
            $baseQuery->where('type', $request->type);
        }
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $baseQuery->whereDate('transaction_date', today());
                    break;
                case 'week':
                    $baseQuery->whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $baseQuery->whereMonth('transaction_date', now()->month)
                              ->whereYear('transaction_date', now()->year);
                    break;
                case 'year':
                    $baseQuery->whereYear('transaction_date', now()->year);
                    break;
            }
        }
        if ($request->filled('date_from')) {
            $baseQuery->whereDate('transaction_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $baseQuery->whereDate('transaction_date', '<=', $request->date_to);
        }

        $periodIncome = (clone $baseQuery)->where('type', 'income')->sum('amount');
        $periodExpense = (clone $baseQuery)->where('type', 'expense')->sum('amount');

        return view('transactions.history', compact('transactions', 'periodIncome', 'periodExpense'));
    }

    /**
     * Form tambah transaksi
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Simpan transaksi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'payment_method' => 'nullable|in:cash,bank,stock,e-wallet,credit_card',
        ]);

        $validated['user_id'] = Auth::id();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Form edit transaksi
     */
    public function edit(Transaction $transaction)
    {
        // Pastikan transaksi milik user yang login
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('transactions.create', compact('transaction'));
    }

    /**
     * Update transaksi
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Pastikan transaksi milik user yang login
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'payment_method' => 'nullable|in:cash,bank,stock,e-wallet,credit_card',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diupdate!');
    }

    /**
     * Hapus transaksi
     */
    public function destroy(Transaction $transaction)
    {
        // Pastikan transaksi milik user yang login
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->delete();

        return redirect()->back()
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}
