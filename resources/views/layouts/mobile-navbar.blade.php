<nav class="mobile-navbar">
    <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="material-icons-round">dashboard</span>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('transactions.index') }}"
        class="mobile-nav-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
        <span class="material-icons-round">receipt_long</span>
        <span>Transaksi</span>
    </a>
    <a href="{{ route('transactions.history') }}"
        class="mobile-nav-item {{ request()->routeIs('transactions.history') ? 'active' : '' }}">
        <span class="material-icons-round">history</span>
        <span>Riwayat</span>
    </a>
</nav>
