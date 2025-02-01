{{-- <div class="mt-3">
    <img src="{{ asset('images/logo_kopling.png') }}" width="180px" style="margin-left: 25px;" alt="logo icon">
</div> --}}
{{-- <ul class="metismenu mt-3" id="menu">
    <li>
        @if (Auth::user()->getRoleNames()[0] == 'admin')
    <li>
        <a href="{{ route('dashboard') }}">
            <div class="parent-icon"><i class='bx bx-home-alt'></i>
            </div>
            <div class="menu-title">Dashboard</div>
        </a>
    </li>
    <li class="menu-label">Aktivitas</li>
    <li>
        <a href="{{ route('barang-masuk.create') }}">
            <div class="parent-icon"><i class="bx bx-log-in-circle"></i>
            </div>
            <div class="menu-title">Form Penerimaan Barang</div>
        </a>
    </li>
    <li>
        <a href="{{ route('barang-masuk.index') }}">
            <div class="parent-icon"><i class="bx bx-list-ul"></i>
            </div>
            <div class="menu-title">Daftar Barang Masuk</div>
        </a>
    </li>
    <li>
        <a href="{{ route('report.listmutasistok.index') }}">
            <div class="parent-icon"><i class="bx bx-transfer-alt"></i>
            </div>
            <div class="menu-title">Mutasi Stok</div>
        </a>
    </li>
    @endif
    @if (Auth::user()->getRoleNames()[0] == 'canvaser')
        <li>
            <a href="{{ route('dashboard.sales') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="{{ route('visit.index') }}">
                <div class="parent-icon"><i class="bx bx-calendar-check"></i>
                </div>
                <div class="menu-title">Visit</div>
            </a>
        </li>
        <li>
            <a href="{{ route('penjualan.index') }}">
                <div class="parent-icon"><i class="bx bx-cart"></i>
                </div>
                <div class="menu-title">List Penjualan</div>
            </a>
        </li>
    @endif
    @if (Auth::user()->getRoleNames()[0] == 'admin')
        <li>
            <a href="{{ route('penjualan.index') }}">
                <div class="parent-icon"><i class="bx bx-cart"></i>
                </div>
                <div class="menu-title">List Penjualan</div>
            </a>
        </li>
        <li>
            <a href="{{ route('konversi.index') }}">
                <div class="parent-icon"><i class="bx bx-refresh"></i>
                </div>
                <div class="menu-title">List Penukaran Poin</div>
            </a>
        </li>
        <li>
            <a href="{{ route('survey-stok.index') }}">
                <div class="parent-icon"><i class="bx bx-check-circle"></i>
                </div>
                <div class="menu-title">List Survey Stok</div>
            </a>
        </li>
        <li>
            <a href="{{ route('visited.index') }}">
                <div class="parent-icon"><i class="bx bx-check-circle"></i>
                </div>
                <div class="menu-title">List Visit</div>
            </a>
        </li>
        <li>
            <a href="{{ route('pbk.index') }}">
                <div class="parent-icon"><i class="bx bx-check-circle"></i>
                </div>
                <div class="menu-title">List PBK</div>
            </a>
        </li>
    @endif

    <li>
        <a href="{{ route('schedule.index') }}">
            <div class="parent-icon"><i class="bx bx-calendar"></i>
            </div>
            <div class="menu-title">Jadwal Visit</div>
        </a>
    </li>
    <li class="menu-label">Master</li>

    <li>
        <a href="{{ route('customers.index') }}">
            <div class="parent-icon"><i class="bx bx-group"></i>
            </div>
            <div class="menu-title">Pelanggan</div>
        </a>
    </li>
    @if (Auth::user()->getRoleNames()[0] == 'admin')
        <li>
            <a href="{{ route('canvaser.index') }}">
                <div class="parent-icon"><i class="bx bx-group"></i>
                </div>
                <div class="menu-title">Canvaser</div>
            </a>
        </li>
    @endif
    <li>
        <a href="{{ route('products.index') }}">
            <div class="parent-icon"><i class="bx bx-box"></i>
            </div>
            <div class="menu-title">Produk</div>
        </a>
    </li>
    @if (Auth::user()->getRoleNames()[0] == 'admin')
        <li>
            <a href="{{ route('users.index') }}">
                <div class="parent-icon"><i class="bx bx-user"></i>
                </div>
                <div class="menu-title">User</div>
            </a>
        </li>
        <li>
            <a href="{{ route('periode-promosi.index') }}">
                <div class="parent-icon"><i class="bx bx-time"></i>
                </div>
                <div class="menu-title">Periode Promosi</div>
            </a>
        </li>
    @endif

    @if (Auth::user()->getRoleNames()[0] == 'admin')
        <li class="menu-label">Report</li>
        <li>
            <a href="{{ route('report.weekly') }}">
                <div class="parent-icon"><i class="bx bx-bar-chart"></i>
                </div>
                <div class="menu-title">Weekly Report</div>
            </a>
        </li>
        <li>
            <a href="{{ route('summary.sales') }}">
                <div class="parent-icon"><i class="bx bx-bar-chart"></i>
                </div>
                <div class="menu-title">Sales Report</div>
            </a>
        </li>
    @endif

    </li>
</ul> --}}

{{-- <ul class="metismenu mt-3" id="menu">
    @if (Auth::user()->getRoleNames()[0] == 'admin')
        <li>
            <a href="{{ route('login') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard Admin</div>
            </a>
        </li>
    @endif
    @if (Auth::user()->getRoleNames()[0] == 'owner')
        <li>
            <a href="{{ route('login') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard Owner</div>
            </a>
        </li>
        <li>
            <a href="{{ route('login') }}">
                <div class="parent-icon"><i class="bx bx-group"></i>
                </div>
                <div class="menu-title">Canvaser</div>
            </a>
        </li>
    @endif

</ul> --}}

<div class="sidebar-wrapper" data-simplebar="init">
    <div class="simplebar-wrapper" style="margin: 0px;">
        <div class="simplebar-height-auto-observer-wrapper">
            <div class="simplebar-height-auto-observer"></div>
        </div>
        <div class="simplebar-mask">
            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                    <div class="simplebar-content mm-active" style="padding: 0px;">
                        {{-- header --}}
                        <div class="sidebar-header">
                            <div>
                                <h4 class="logo-text">Toko Usaha Mandiri</h4>
                            </div>
                            <div class="toggle-icon ms-auto"><i class="bx bx-arrow-back"></i>
                            </div>
                        </div>
                        <!--navigation-->
                        <ul class="metismenu mm-show" id="menu">
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <div class="parent-icon"><i class='bx bx-home-alt'></i>
                                    </div>
                                    <div class="menu-title">Dashboard</div>
                                </a>
                            </li>
                            {{-- @if (Auth::user()->getRoleNames()[0] == 'owner')
                                <li>
                                    <a href="{{ route('dashboard') }}">
                                        <div class="parent-icon"><i class='bx bx-home-alt'></i>
                                        </div>
                                        <div class="menu-title">Dashboard</div>
                                    </a>
                                </li>
                            @endif --}}

                            {{-- Contoh menggunakan level --}}
                            {{-- <li>
                                    <a href="javascript:;" class="has-arrow">
                                        <div class="parent-icon"><i class="bx bx-cart"></i>
                                        </div>
                                        <div class="menu-title">Users</div>
                                    </a>
                                    <ul class="mm-collapse">
                                        <li> <a href="ecommerce-products.html"><i
                                                    class="bx bx-radio-circle"></i>Products</a>
                                        </li>
                                        <li> <a href="ecommerce-products-details.html"><i
                                                    class="bx bx-radio-circle"></i>Product Details</a>
                                        </li>
                                        <li> <a href="ecommerce-add-new-products.html"><i
                                                    class="bx bx-radio-circle"></i>Add
                                                New Products</a>
                                        </li>
                                        <li> <a href="ecommerce-orders.html"><i
                                                    class="bx bx-radio-circle"></i>Orders</a>
                                        </li>
                                    </ul>
                                </li> --}}

                            {{-- @if (Auth::user()->getRoleNames()[0] == 'admin')
                                <li>
                                    <a href="{{ route('dashboard') }}">
                                        <div class="parent-icon"><i class='bx bx-home-alt'></i>
                                        </div>
                                        <div class="menu-title">Dashboard Admin</div>
                                    </a>
                                </li>
                            @endif --}}

                            @if (Auth::user()->can('module_barangmasuk'))
                                <li>
                                    <a href="{{ route('barang-masuk.index') }}">
                                        <div class="parent-icon"><i class='bx bx-box'></i>
                                        </div>
                                        <div class="menu-title">Barang Masuk</div>
                                    </a>
                                </li>
                            @endif

                            {{-- Permissions barang --}}
                            @if (Auth::user()->can('module_barang'))
                                <li>
                                    <a href="{{ route('barangs.index') }}">
                                        <div class="parent-icon"><i class='bx bx-box'></i>
                                        </div>
                                        <div class="menu-title">Barang</div>
                                    </a>
                                </li>
                            @endif

                            {{-- Permissions Supplier --}}
                            @if (Auth::user()->can('module_supplier'))
                                <li>
                                    <a href="{{ route('supplier.index') }}">
                                        <div class="parent-icon"><i class='bx bxs-truck'></i>
                                        </div>
                                        <div class="menu-title">Supplier</div>
                                    </a>
                                </li>
                            @endif

                            {{-- Permissions User Privilages --}}
                            @if (Auth::user()->can('module_settinguserprivilage'))
                                <li>
                                    <a href="{{ route('users.index') }}">
                                        <div class="parent-icon"><i class='bx bx-user'></i>
                                        </div>
                                        <div class="menu-title">Pengguna</div>
                                    </a>
                                </li>
                            @endif

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
