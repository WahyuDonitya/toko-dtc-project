<div class="sidebar-wrapper" data-simplebar="init">
    <div class="simplebar-wrapper" style="margin: 0px;">
        <div class="simplebar-height-auto-observer-wrapper">
            <div class="simplebar-height-auto-observer"></div>
        </div>
        <div class="simplebar-mask">
            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                    <div class="simplebar-content mm-active" style="padding: 0px;">
                        <!-- Header -->
                        <div class="sidebar-header">
                            <div>
                                <h4 class="logo-text">Toko Usaha Mandiri</h4>
                            </div>
                            <div class="toggle-icon ms-auto"><i class="bx bx-arrow-back"></i></div>
                        </div>

                        <!-- Navigation -->
                        <ul class="metismenu mm-show" id="menu">
                            <!-- Dashboard -->
                            <li class="menu-label">Utama</li>
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                                    <div class="menu-title">Dashboard</div>
                                </a>
                            </li>

                            <!-- Pembelian -->
                            @if (Auth::user()->can('module_purchaseorder'))
                                <li class="menu-label">Pembelian</li>
                                <li>
                                    <a href="{{ route('purchase-order.create') }}">
                                        <div class="parent-icon"><i class='bx bx-shopping-bag'></i></div>
                                        <div class="menu-title">Buat PO</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('purchase-order.index') }}">
                                        <div class="parent-icon"><i class='bx bx-file'></i></div>
                                        <div class="menu-title">List PO</div>
                                    </a>
                                </li>
                            @endif

                            <!-- Inventory -->
                            <li class="menu-label">Inventory</li>
                            @if (Auth::user()->can('module_barangmasuk'))
                                <li>
                                    <a href="{{ route('barang-masuk.index') }}">
                                        <div class="parent-icon"><i class='bx bx-box'></i></div>
                                        <div class="menu-title">Barang Masuk</div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('barang-keluar.create') }}">
                                        <div class="parent-icon"><i class='bx bx-box'></i></div>
                                        <div class="menu-title">Barang keluar</div>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->can('module_barang'))
                                <li>
                                    <a href="{{ route('barangs.index') }}">
                                        <div class="parent-icon"><i class='bx bx-box'></i></div>
                                        <div class="menu-title">Barang</div>
                                    </a>
                                </li>
                            @endif

                            <!-- Master Data -->
                            <li class="menu-label">Master Data</li>
                            @if (Auth::user()->can('module_supplier'))
                                <li>
                                    <a href="{{ route('supplier.index') }}">
                                        <div class="parent-icon"><i class='bx bxs-truck'></i></div>
                                        <div class="menu-title">Supplier</div>
                                    </a>
                                </li>
                            @endif

                            <!-- Pengguna & Sistem -->
                            <li class="menu-label">Pengaturan Sistem</li>
                            @if (Auth::user()->can('module_settinguserprivilage'))
                                <li>
                                    <a href="{{ route('users.index') }}">
                                        <div class="parent-icon"><i class='bx bx-user'></i></div>
                                        <div class="menu-title">Pengguna</div>
                                    </a>
                                </li>
                            @endif

                            <!-- Laporan -->
                            <li class="menu-label">Laporan</li>
                            <li>
                                <a href="#">
                                    <div class="parent-icon"><i class='bx bx-printer'></i></div>
                                    <div class="menu-title">Laporan Pembelian</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="parent-icon"><i class='bx bx-printer'></i></div>
                                    <div class="menu-title">Laporan Inventory</div>
                                </a>
                            </li>
                        </ul>
                        <!--end navigation-->
                    </div>
                </div>
            </div>
        </div>
        <div class="simplebar-placeholder" style="width: auto; height: 1678px;"></div>
    </div>
    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
    </div>
    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
        <div class="simplebar-scrollbar" style="height: 439px; transform: translate3d(0px, 0px, 0px); display: block;">
        </div>
    </div>
</div>
