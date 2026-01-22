@extends('layouts.app')

@section('title', 'Kelola Transaksi')

@section('content')
    <div class="page active">
        <div class="page-header">
            <div>
                <h1 class="page-title">Kelola Transaksi</h1>
                <p class="page-subtitle">Tambah, edit, dan hapus transaksi</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="btn-primary">
                    <span class="material-icons-round">add</span>
                    Pemasukan
                </a>
                <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="btn-danger">
                    <span class="material-icons-round">remove</span>
                    Pengeluaran
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="stats-grid">
            <div class="stat-card glass-card">
                <div class="stat-icon-wrapper success-bg">
                    <span class="material-icons-round">arrow_upward</span>
                </div>
                <div class="stat-details">
                    <p class="stat-label">Total Pemasukan</p>
                    <h3 class="stat-amount">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="stat-card glass-card">
                <div class="stat-icon-wrapper danger-bg">
                    <span class="material-icons-round">arrow_downward</span>
                </div>
                <div class="stat-details">
                    <p class="stat-label">Total Pengeluaran</p>
                    <h3 class="stat-amount">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="stat-card glass-card">
                <div class="stat-icon-wrapper primary-bg">
                    <span class="material-icons-round">account_balance_wallet</span>
                </div>
                <div class="stat-details">
                    <p class="stat-label">Selisih</p>
                    <h3 class="stat-amount">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>


        <!-- Transactions Table -->
        <div class="section-card glass-card">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Kategori</th>
                            <th>Metode</th>
                            <th>Keterangan</th>
                            <th class="text-right">Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                <td>
                                    <span
                                        class="badge {{ $transaction->type === 'income' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td>{{ $transaction->category ?? '-' }}</td>
                                <td>{{ $transaction->payment_method_label ?? '-' }}</td>
                                <td class="transaction-description">{{ $transaction->description ?? '-' }}</td>
                                <td class="text-right {{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                                    <strong>{{ $transaction->type === 'income' ? '+' : '-' }} Rp
                                        {{ number_format($transaction->amount, 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn-icon btn-edit"
                                            title="Edit">
                                            <span class="material-icons-round">edit</span>
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-delete" title="Hapus">
                                                <span class="material-icons-round">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="empty-state">
                                        <span class="material-icons-round">inbox</span>
                                        <p>Tidak ada transaksi ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($transactions->hasPages())
                <div class="pagination-wrapper">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
