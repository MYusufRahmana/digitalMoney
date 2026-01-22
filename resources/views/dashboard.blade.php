@extends('layouts.app')

@section('title', 'Dashboard - Aturduit')

@section('content')
    <div class="page active">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>
        </div>

        <!-- Balance Overview Card -->
        <div class="glass-card"
            style="padding: 32px; margin-bottom: 24px; background: linear-gradient(135deg, #3c4f76 0%, #2d3e5f 100%); color: white; border: none;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <p
                        style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-bottom: 8px;">
                        Total Saldo</p>
                    <h2 style="font-size: 40px; font-weight: 700; margin-bottom: 24px;">Rp
                        {{ number_format($totalBalance, 0, ',', '.') }}</h2>

                    <div
                        style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.2);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div
                                style="width: 48px; height: 48px; background: rgba(72, 187, 120, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <span class="material-icons-round" style="color: #48bb78;">trending_up</span>
                            </div>
                            <div>
                                <p style="font-size: 11px; text-transform: uppercase; opacity: 0.7; margin-bottom: 4px;">
                                    Pemasukan Bulan Ini</p>
                                <p style="font-size: 18px; font-weight: 700; color: #48bb78;">Rp
                                    {{ number_format($monthlyIncome, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div
                                style="width: 48px; height: 48px; background: rgba(245, 101, 101, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <span class="material-icons-round" style="color: #f56565;">trending_down</span>
                            </div>
                            <div>
                                <p style="font-size: 11px; text-transform: uppercase; opacity: 0.7; margin-bottom: 4px;">
                                    Pengeluaran Bulan Ini</p>
                                <p style="font-size: 18px; font-weight: 700; color: #f56565;">Rp
                                    {{ number_format($monthlyExpense, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    style="width: 80px; height: 80px; background: rgba(255,255,255,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                    <span class="material-icons-round" style="font-size: 40px; color: white;">account_balance</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; margin-bottom: 24px;">
            <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="glass-card"
                style="padding: 20px; display: flex; align-items: center; gap: 16px; text-decoration: none; transition: all 0.2s ease;">
                <div
                    style="width: 56px; height: 56px; background: linear-gradient(135deg, #48bb78, #38a169); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <span class="material-icons-round" style="color: white; font-size: 28px;">add_circle</span>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Tambah
                        Pemasukan</h3>
                    <p style="font-size: 13px; color: var(--text-secondary);">Catat pendapatan Anda</p>
                </div>
            </a>

            <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="glass-card"
                style="padding: 20px; display: flex; align-items: center; gap: 16px; text-decoration: none; transition: all 0.2s ease;">
                <div
                    style="width: 56px; height: 56px; background: linear-gradient(135deg, #f56565, #e53e3e); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <span class="material-icons-round" style="color: white; font-size: 28px;">remove_circle</span>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Tambah
                        Pengeluaran</h3>
                    <p style="font-size: 13px; color: var(--text-secondary);">Catat pengeluaran Anda</p>
                </div>
            </a>

            <a href="{{ route('transactions.index') }}" class="glass-card"
                style="padding: 20px; display: flex; align-items: center; gap: 16px; text-decoration: none; transition: all 0.2s ease;">
                <div
                    style="width: 56px; height: 56px; background: linear-gradient(135deg, #4299e1, #3182ce); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <span class="material-icons-round" style="color: white; font-size: 28px;">receipt_long</span>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Lihat
                        Transaksi</h3>
                    <p style="font-size: 13px; color: var(--text-secondary);">Kelola semua transaksi</p>
                </div>
            </a>

            <a href="{{ route('transactions.history') }}" class="glass-card"
                style="padding: 20px; display: flex; align-items: center; gap: 16px; text-decoration: none; transition: all 0.2s ease;">
                <div
                    style="width: 56px; height: 56px; background: linear-gradient(135deg, #9f7aea, #805ad5); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <span class="material-icons-round" style="color: white; font-size: 28px;">history</span>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Riwayat
                    </h3>
                    <p style="font-size: 13px; color: var(--text-secondary);">Lihat riwayat lengkap</p>
                </div>
            </a>
        </div>

        <!-- Recent Transactions -->
        <div class="glass-card section-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2
                    style="font-size: 18px; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                    <span class="material-icons-round" style="color: var(--primary);">history</span>
                    Transaksi Terbaru
                </h2>
                <a href="{{ route('transactions.history') }}" class="btn-link">
                    Lihat Semua
                    <span class="material-icons-round">arrow_forward</span>
                </a>
            </div>

            <div class="transactions-list">
                @forelse($recentTransactions as $transaction)
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
                                {{ $transaction->transaction_date->format('d M Y') }}
                                @if ($transaction->payment_method)
                                    • {{ $transaction->payment_method_label }}
                                @endif
                            </p>
                        </div>
                        <div class="transaction-amount {{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp
                            {{ number_format($transaction->amount, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <span class="material-icons-round">inbox</span>
                        <p>Belum ada transaksi</p>
                        <a href="{{ route('transactions.create') }}" class="btn-primary" style="margin-top: 16px;">
                            <span class="material-icons-round">add</span>
                            Tambah Transaksi Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
