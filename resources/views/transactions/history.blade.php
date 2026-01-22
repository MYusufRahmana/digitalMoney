@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="page active">
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Transaksi</h1>
            <p class="page-subtitle">Lihat semua aktivitas keuangan Anda</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar glass-card">
        <form action="{{ route('transactions.history') }}" method="GET" id="historyFilterForm">
            <div class="filter-group">
                <label class="filter-label">Tipe</label>
                <select name="type" class="filter-select" onchange="document.getElementById('historyFilterForm').submit()">
                    <option value="">Semua</option>
                    <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Periode</label>
                <select name="period" class="filter-select" onchange="document.getElementById('historyFilterForm').submit()">
                    <option value="">Semua</option>
                    <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Dari Tanggal</label>
                <input type="date" name="date_from" class="filter-select" value="{{ request('date_from') }}">
            </div>
            <div class="filter-group">
                <label class="filter-label">Sampai Tanggal</label>
                <input type="date" name="date_to" class="filter-select" value="{{ request('date_to') }}">
            </div>
            <div class="filter-group">
                <button type="submit" class="btn-primary">
                    <span class="material-icons-round">search</span>
                    Filter
                </button>
                @if(request()->hasAny(['type', 'period', 'date_from', 'date_to']))
                    <a href="{{ route('transactions.history') }}" class="btn-secondary">
                        <span class="material-icons-round">refresh</span>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Summary for filtered period -->
    @if($transactions->count() > 0)
    <div class="stats-grid">
        <div class="stat-card glass-card">
            <div class="stat-icon-wrapper success-bg">
                <span class="material-icons-round">arrow_upward</span>
            </div>
            <div class="stat-details">
                <p class="stat-label">Pemasukan Periode Ini</p>
                <h3 class="stat-amount success">Rp {{ number_format($periodIncome, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="stat-card glass-card">
            <div class="stat-icon-wrapper danger-bg">
                <span class="material-icons-round">arrow_downward</span>
            </div>
            <div class="stat-details">
                <p class="stat-label">Pengeluaran Periode Ini</p>
                <h3 class="stat-amount danger">Rp {{ number_format($periodExpense, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="stat-card glass-card">
            <div class="stat-icon-wrapper primary-bg">
                <span class="material-icons-round">receipt</span>
            </div>
            <div class="stat-details">
                <p class="stat-label">Total Transaksi</p>
                <h3 class="stat-amount">{{ $transactions->total() }}</h3>
            </div>
        </div>
    </div>
    @endif

    <!-- Transactions List -->
    <div class="section-card glass-card">
        <div class="transactions-list">
            @forelse($transactions as $transaction)
            <div class="transaction-item">
                <div class="transaction-icon {{ $transaction->type === 'income' ? 'success-bg' : 'danger-bg' }}">
                    <span class="material-icons-round">
                        {{ $transaction->type === 'income' ? 'arrow_upward' : 'arrow_downward' }}
                    </span>
                </div>
                <div class="transaction-info">
                    <h4 class="transaction-title">{{ $transaction->category ?? 'Tanpa Kategori' }}</h4>
                    <p class="transaction-desc">{{ $transaction->description ?? '-' }}</p>
                    <p class="transaction-date">
                        {{ $transaction->transaction_date->format('d M Y, H:i') }} •
                        {{ $transaction->payment_method_label ?? 'Tidak ada metode' }}
                    </p>
                </div>
                <div class="transaction-actions">
                    <div class="transaction-amount {{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </div>
                    <div class="action-buttons-inline">
                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn-icon-sm" title="Edit">
                            <span class="material-icons-round">edit</span>
                        </a>
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                            style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon-sm" title="Hapus">
                                <span class="material-icons-round">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <span class="material-icons-round">inbox</span>
                <p>Tidak ada riwayat transaksi</p>
                <a href="{{ route('transactions.create') }}" class="btn-primary">
                    <span class="material-icons-round">add</span>
                    Tambah Transaksi Pertama
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="pagination-wrapper">
            {{ $transactions->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
