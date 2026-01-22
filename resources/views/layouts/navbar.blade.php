<nav class="navbar">
    <div class="nav-brand">
        <span class="material-icons-round">account_balance_wallet</span>
        <span class="brand-text">Aturduit</span>
    </div>

    <div class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="material-icons-round">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('transactions.index') }}"
            class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <span class="material-icons-round">receipt_long</span>
            <span>Transaksi</span>
        </a>
        <a href="{{ route('transactions.history') }}"
            class="nav-item {{ request()->routeIs('transactions.history') ? 'active' : '' }}">
            <span class="material-icons-round">history</span>
            <span>Riwayat</span>
        </a>
    </div>

    <div class="nav-actions">
        <button class="theme-toggle" id="themeToggle">
            <span class="material-icons-round">light_mode</span>
        </button>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn-logout" title="Logout">
                <span class="material-icons-round">logout</span>
            </button>
        </form>
    </div>
</nav>
