<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'payment_method',
        'amount',
        'category',
        'description',
        'transaction_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk pemasukan
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    // Scope untuk pengeluaran
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope untuk filter berdasarkan payment method
    public function scopePaymentMethod($query, $paymentMethod)
    {
        return $query->where('payment_method', $paymentMethod);
    }

    // Accessor untuk format amount dengan mata uang
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // Accessor untuk label payment method
    public function getPaymentMethodLabelAttribute()
    {
        if (!$this->payment_method) {
            return null;
        }

        $labels = [
            'cash' => 'Tunai',
            'bank' => 'Bank',
            'stock' => 'Saham',
            'e-wallet' => 'E-Wallet',
            'credit_card' => 'Kartu Kredit',
        ];

        return $labels[$this->payment_method] ?? $this->payment_method;
    }

    // Accessor untuk icon berdasarkan payment method
    public function getPaymentMethodIconAttribute()
    {
        $icons = [
            'cash' => 'payments',
            'bank' => 'account_balance',
            'stock' => 'trending_up',
            'e-wallet' => 'account_balance_wallet',
            'credit_card' => 'credit_card',
        ];

        return $icons[$this->payment_method] ?? 'payments';
    }

    // Accessor untuk warna berdasarkan type
    public function getTypeColorAttribute()
    {
        return $this->type === 'income' ? 'success' : 'danger';
    }

    // Method untuk mendapatkan daftar payment methods
    public static function getPaymentMethods()
    {
        return [
            'cash' => 'Tunai',
            'bank' => 'Bank',
            'stock' => 'Saham',
            'e-wallet' => 'E-Wallet',
            'credit_card' => 'Kartu Kredit',
        ];
    }

    // Method untuk mendapatkan daftar kategori yang tersedia
    public static function getCategories($type = null)
    {
        $categories = [
            'income' => [
                'Gaji',
                'Bonus',
                'Freelance',
                'Investasi',
                'Hadiah',
                'Penjualan',
                'Lainnya'
            ],
            'expense' => [
                'Makanan & Minuman',
                'Transportasi',
                'Belanja',
                'Hiburan',
                'Kesehatan',
                'Pendidikan',
                'Tagihan',
                'Kebutuhan Rumah',
                'Lainnya'
            ]
        ];

        if ($type && isset($categories[$type])) {
            return $categories[$type];
        }

        return array_merge($categories['income'], $categories['expense']);
    }

    // Method untuk mendapatkan daftar types
    public static function getTypes()
    {
        return [
            'income' => 'Pemasukan',
            'expense' => 'Pengeluaran',
        ];
    }
}
