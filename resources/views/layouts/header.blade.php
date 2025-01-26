<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>

            {{-- <div class="search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                <a href="avascript:;" class="btn d-flex align-items-center"><i class='bx bx-search'></i>Search</a>
            </div> --}}

            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">



                    <li class="nav-item dropdown dropdown-app">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"
                            href="javascript:;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="app-container p-2 my-2">
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                            data-bs-toggle="dropdown">


                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    {{-- <p class="msg-header-badge">8 New</p> --}}
                                </div>
                            </a>
                            <div class="header-notifications-list">

                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">
                                    <button class="btn btn-primary w-100">View All Notifications</button>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">

                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">My Cart</p>
                                    <p class="msg-header-badge">10 Items</p>
                                </div>
                            </a>
                            <div class="header-message-list">
                                {{-- <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="position-relative">
                                            <div class="cart-product rounded-circle bg-light">
                                                <img src="{{ asset('assets') }}/images/products/11.png"
                                                    class="" alt="product image">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                            <p class="cart-product-price mb-0">1 X $29.00</p>
                                        </div>
                                        <div class="">
                                            <p class="cart-price mb-0">$250</p>
                                        </div>
                                        <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                        </div>
                                    </div>
                                </a> --}}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                        $user = Auth::user();
                        $fotoPath = $user->pegawai ? $user->pegawai->foto2 : 'pegawai/avatar-2.png';
                    @endphp
                    <img src="{{ asset('uploads/' . $fotoPath) }}" class="user-img" alt="user avatar">
                    <div class="user-info">
                        <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                        <p class="designattion mb-0">{{ Auth::user()->getRoleNames()[0] }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    {{-- <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                class="bx bx-user fs-5"></i><span>Profile</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                class="bx bx-cog fs-5"></i><span>Settings</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                class="bx bx-home-circle fs-5"></i><span>Dashboard</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                class="bx bx-dollar-circle fs-5"></i><span>Earnings</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                class="bx bx-download fs-5"></i><span>Downloads</span></a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li> --}}
                    {{-- <li><a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}"><i
                                class="bx bx-log-out-circle"></i><span>Profile</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('changepassword.index') }}"><i
                                class="bx bx-log-out-circle"></i><span>Change Password</span></a>
                    </li> --}}
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"><i
                                class="bx bx-log-out-circle"></i><span>Logout</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
