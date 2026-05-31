<aside class="sidebar">

    {{-- LOGO --}}
    <div>

        <div class="logo-box">

            <div class="logo-icon">
                🧴
            </div>

            <div>
                <div class="logo-title">
                    Kasir Parfum
                </div>

                <div class="logo-sub">
                    Sistem Kasir Modern
                </div>
            </div>

        </div>

        {{-- MENU --}}
        <div class="menu-list">

            <a href="/dashboard"
               class="menu-link {{ request()->is('dashboard') ? 'active-menu' : '' }}">
                <span>🏠</span>
                Dashboard
            </a>

            <a href="/branches"
               class="menu-link {{ request()->is('branches*') ? 'active-menu' : '' }}">
                <span>🏪</span>
                Cabang
            </a>

            <a href="/categories"
               class="menu-link {{ request()->is('categories*') ? 'active-menu' : '' }}">
                <span>📂</span>
                Kategori
            </a>

            <a href="/products"
               class="menu-link {{ request()->is('products*') ? 'active-menu' : '' }}">
                <span>📦</span>
                Produk
            </a>

            <a href="/bundles"
               class="menu-link {{ request()->is('bundles*') ? 'active-menu' : '' }}">
                <span>🧃</span>
                Bundling
            </a>

            <a href="/payment-methods"
               class="menu-link {{ request()->is('payment-methods*') ? 'active-menu' : '' }}">
                <span>💳</span>
                Pembayaran
            </a>

            <a href="/transactions"
               class="menu-link {{ request()->is('transactions*') ? 'active-menu' : '' }}">
                <span>🧾</span>
                Transaksi
            </a>

            <a href="{{ route('reports.index') }}"
               class="menu-link {{ request()->is('reports*') ? 'active-menu' : '' }}">
                <span>📊</span>
                Laporan
            </a>

        </div>

    </div>

    {{-- USER --}}
    <div class="user-box">

        <div class="user-info">

            <div class="user-avatar">
                👤
            </div>

             <div class="user-name">
                 {{ auth()->user()->name }}
            </div>

        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="logout-btn">
                🚪 Logout
            </button>
        </form>

    </div>

</aside>

<style>

    /* SIDEBAR */
    .sidebar{
        width:280px;
        height:100vh;

        background:
            linear-gradient(
                180deg,
                #312e81,
                #4338ca,
                #4f46e5,
                #6366f1
            );

        padding:24px 18px;

        display:flex;
        flex-direction:column;
        justify-content:space-between;

        box-shadow:
            10px 0 40px rgba(79,70,229,.15);

        overflow-y:auto;
    }

    /* LOGO */
    .logo-box{
        display:flex;
        align-items:center;
        gap:14px;

        margin-bottom:35px;
    }

    .logo-icon{
        width:52px;
        height:52px;

        border-radius:18px;

        background:
            rgba(255,255,255,.15);

        display:flex;
        align-items:center;
        justify-content:center;

        font-size:24px;

        backdrop-filter:blur(10px);
    }

    .logo-title{
        color:white;
        font-size:22px;
        font-weight:700;
    }

    .logo-sub{
        color:#c7d2fe;
        font-size:13px;
        margin-top:3px;
    }

    /* MENU */
    .menu-list{
        display:flex;
        flex-direction:column;
        gap:10px;
    }

    .menu-link{
        display:flex;
        align-items:center;
        gap:12px;

        padding:14px 16px;

        border-radius:16px;

        text-decoration:none;

        color:#e0e7ff;

        font-size:14px;
        font-weight:500;

        transition:0.25s;
    }

    .menu-link:hover{
        background:rgba(255,255,255,.15);
        color:white;

        transform:translateX(4px);
    }

    .active-menu{
        background:white;
        color:#4338ca !important;

        font-weight:700;

        box-shadow:
            0 10px 30px rgba(255,255,255,.15);
    }

    /* USER */
    .user-box{
        background:rgba(255,255,255,.12);

        border:1px solid rgba(255,255,255,.15);

        padding:18px;

        border-radius:22px;

        backdrop-filter:blur(12px);
    }

    .user-info{
        display:flex;
        align-items:center;
        gap:12px;

        margin-bottom:16px;
    }

    .user-avatar{
        width:45px;
        height:45px;

        border-radius:14px;

        background:white;

        display:flex;
        align-items:center;
        justify-content:center;
    }

    .user-name{
        color:white;
        font-weight:600;
        font-size:14px;
    }

    .user-role{
        color:#c7d2fe;
        font-size:12px;
        margin-top:2px;
    }

    /* LOGOUT */
    .logout-btn{
        width:100%;

        border:none;

        background:#ef4444;
        color:white;

        padding:12px;

        border-radius:14px;

        cursor:pointer;

        font-weight:600;

        transition:0.2s;
    }

    .logout-btn:hover{
        background:#dc2626;
    }

    /* MOBILE */
    @media(max-width:768px){

        .sidebar{
            width:220px;
        }

    }

</style>