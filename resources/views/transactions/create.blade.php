@extends('layouts.app')

@section('title', $transaction ?? false ? 'Edit Transaksi' : 'Tambah Transaksi')

@section('content')
    <div class="page active">
        <div class="page-header">
            <div>
                <h1 class="page-title">{{ $transaction ?? false ? 'Edit Transaksi' : 'Tambah Transaksi' }}</h1>
                <p class="page-subtitle">{{ $transaction ?? false ? 'Ubah data transaksi' : 'Catat transaksi baru' }}</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="btn-secondary">
                <span class="material-icons-round">arrow_back</span>
                Kembali
            </a>
        </div>

        <div class="section-card glass-card">
            <form
                action="{{ $transaction ?? false ? route('transactions.update', $transaction) : route('transactions.store') }}"
                method="POST">
                @csrf
                @if ($transaction ?? false)
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <!-- Type -->
                    <div class="form-group full-width">
                        <label class="form-label required">Tipe Transaksi</label>
                        <div class="radio-group">
                            <label class="radio-card">
                                <input type="radio" name="type" value="income"
                                    {{ old('type', $transaction->type ?? request('type')) === 'income' ? 'checked' : '' }}
                                    required>
                                <div class="radio-content success-border">
                                    <span class="material-icons-round success">add_circle</span>
                                    <span>Pemasukan</span>
                                </div>
                            </label>
                            <label class="radio-card">
                                <input type="radio" name="type" value="expense"
                                    {{ old('type', $transaction->type ?? request('type')) === 'expense' ? 'checked' : '' }}
                                    required>
                                <div class="radio-content danger-border">
                                    <span class="material-icons-round danger">remove_circle</span>
                                    <span>Pengeluaran</span>
                                </div>
                            </label>
                        </div>
                        @error('type')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount" class="form-label required">Jumlah</label>
                        <div class="input-group">
                            <span class="input-prefix">Rp</span>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="0"
                                step="0.01" min="0.01" value="{{ old('amount', $transaction->amount ?? '') }}"
                                required>
                        </div>
                        @error('amount')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Transaction Date -->
                    <div class="form-group">
                        <label for="transaction_date" class="form-label required">Tanggal</label>
                        <input type="date" id="transaction_date" name="transaction_date" class="form-control"
                            value="{{ old('transaction_date', $transaction->transaction_date ?? now()->format('Y-m-d')) }}"
                            required>
                        @error('transaction_date')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select id="payment_method" name="payment_method" class="form-control">
                            <option value="">Pilih Metode</option>
                            @foreach (\App\Models\Transaction::getPaymentMethods() as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('payment_method', $transaction->payment_method ?? '') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_method')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label for="category" class="form-label">Kategori</label>
                        <input type="text" id="category" name="category" class="form-control"
                            placeholder="Contoh: Gaji, Makanan, dll"
                            value="{{ old('category', $transaction->category ?? '') }}" maxlength="255">
                        @error('category')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group full-width">
                        <label for="description" class="form-label">Keterangan</label>
                        <textarea id="description" name="description" class="form-control" rows="3"
                            placeholder="Tambahkan catatan (opsional)">{{ old('description', $transaction->description ?? '') }}</textarea>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('transactions.index') }}" class="btn-secondary">
                        <span class="material-icons-round">close</span>
                        Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <span class="material-icons-round">save</span>
                        {{ $transaction ?? false ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
