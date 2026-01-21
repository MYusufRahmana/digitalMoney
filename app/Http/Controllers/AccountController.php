<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Query langsung dengan user_id
        $accounts = Account::where('user_id', Auth::id())
            ->withCount('transactions')
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:digital,cash,saham,lainnya',
            'account_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['balance'] = 0;
        $validated['is_active'] = true;

        Account::create($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Akun berhasil ditambahkan!');
    }

    public function show(Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        $transactions = $account->transactions()
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('accounts.show', compact('account', 'transactions'));
    }

    public function edit(Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:digital,cash,saham,lainnya',
            'account_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Akun berhasil diupdate!');
    }

    public function destroy(Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        if ($account->transactions()->count() > 0) {
            return back()->withErrors([
                'error' => 'Akun tidak bisa dihapus karena masih memiliki ' .
                          $account->transactions()->count() . ' transaksi. Nonaktifkan saja.'
            ]);
        }

        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Akun berhasil dihapus!');
    }

    public function toggleStatus(Account $account)
    {
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        $account->is_active = !$account->is_active;
        $account->save();

        $status = $account->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Akun {$account->name} berhasil {$status}!");
    }
}
