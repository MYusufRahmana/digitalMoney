<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['income', 'expense'])->comment('income = pemasukkan, expense = pengeluaran');
            $table->enum('payment_method', ['cash', 'bank', 'stock', 'e-wallet', 'credit_card'])->default('cash')->comment('Jenis uang/alat bayar');
            $table->decimal('amount', 15, 2);
            $table->string('category');
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->timestamps();

            // Index untuk performa query yang lebih baik
            $table->index(['user_id', 'transaction_date']);
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'payment_method']);
            $table->index(['user_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
