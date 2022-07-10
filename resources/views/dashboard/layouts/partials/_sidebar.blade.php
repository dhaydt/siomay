<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="index.html">
            <img alt="Logo"
                src="{{ $web_config ? asset($web_config['web_logo']) : asset('assets/images/logo/masnur.png') }}"
                class="h-50px logo" />
        </a>
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="currentColor" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Master</span>
                    </div>
                </div>
                <div class="menu-item">
                    {{-- <a class="menu-link @if($active == " home") active @endif" href="{{ route('admin.home') }}">
                        --}}
                        <a class="menu-link @if($active == " dashboard") active @endif" href="{{ route('dashboard') }}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                </div>
                @if (session()->get('role') == 1)
                <div class="menu-item">
                    <a class="menu-link @if($active == " Data Cabang") active @endif" href="{{ route('cabang') }}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="fas fa-store"></i>
                            </span>
                        </span>
                        <span class="menu-title">Cabang</span>
                    </a>
                </div>
                @endif

                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion @if($active == 'Data Karyawan' || $active == 'Data Administrator' || $active == 'Data Admin Cabang' || $active == 'Data Kasir' || $active == 'Data Gudang') show active @endif"">
                    <span class=" menu-link @if($active=='Data Karyawan' || $active=='Data Administrator' ||
                    $active=='Data Admin Cabang' || $active=='Data Kasir' || $active=='Data Gudang' ) show active
                    @endif">
                    <span class="menu-icon">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path opacity="0.3"
                                    d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z"
                                    fill="currentColor" />
                                <path
                                    d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                    </span>
                    <span class="menu-title">Karyawan</span>
                    <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        @if (session()->get('role') == 1)
                        <div class="menu-item">
                            <a class="menu-link @if($active == 'Data Karyawan') active @endif"
                                href="{{ route('user.list', ['status' => 'status?status=all']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Semua karyawan</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if($active == 'Data Administrator') active @endif"
                                href="{{ route('user.list', ['status' => 'status?status=1']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Administrator</span>
                            </a>
                        </div>
                        @endif
                        <div class="menu-item">
                            <a class="menu-link @if($active == 'Data Admin Cabang') active @endif"
                                href="{{ route('user.list', ['status' => 'status?status=2']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Admin Cabang</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if($active == 'Data Kasir') active @endif"
                                href="{{ route('user.list', ['status' => 'status?status=3']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Kasir</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if($active == 'Data Gudang') active @endif"
                                href="{{ route('user.list', ['status' => 'status?status=4']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Gudang</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link @if($active == " Data Produk") active @endif" href="{{ route('produk') }}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="fas fa-cubes"></i>
                            </span>
                        </span>
                        <span class="menu-title">Produk</span>
                    </a>
                </div>

                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Transaksi</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link @if($active == "daerah") active @endif" href="">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="fas fa-handshake"></i>
                            </span>
                        </span>
                        <span class="menu-title">Penjualan</span>
                    </a>
                </div>

                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion @if($active == 'Data Stock Gudang Pusat' || $active == 'Data Stock Gudang Cabang') show active @endif"">
                    <span class=" menu-link @if($active=='Data Stock Gudang' || $active=='Pengajuan Stock' ) show active
                    @endif">
                    <span class="menu-icon">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-warehouse"></i>
                        </span>
                    </span>
                    <span class="menu-title">Data Gudang</span>
                    <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link @if($active == "Data Stock Gudang Pusat") active @endif"
                                href="{{ route('gudang', ['status' => 'status?status=pusat']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Gudang Pusat</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if($active == 'Data Stock Gudang Cabang') active @endif"
                                href="{{ route('gudang', ['status' => 'status?status=cabang']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Gudang Cabang</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion @if($active == 'Pengajuan Stock Baru' || $active == 'Pengajuan Stock Dikirim' || $active == 'Pengajuan Stock Diterima') show active @endif"">
                    <span class=" menu-link @if($active=='Pengajuan Stock Diterima' || $active=='Pengajuan Stock Dikirim' || $active == 'Pengajuan Stock Baru' ) show active
                    @endif">
                    <span class="menu-icon">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-dolly"></i>
                        </span>
                    </span>
                    <span class="menu-title">Pengajuan Stock</span>
                    <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link @if($active == 'Pengajuan Stock Baru') active @endif"
                                href="{{ route('pengajuan_stock', ['status' => 'status?status=menunggu']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Pengajuan Stock Baru</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link @if($active == 'Pengajuan Stock Dikirim') active @endif"
                                href="{{ route('pengajuan_stock', ['status' => 'status?status=dikirim']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Pengajuan Stock dikirim</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link @if($active == 'Pengajuan Stock Diterima') active @endif"
                                href="{{ route('pengajuan_stock', ['status' => 'status?status=diterima']) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Pengajuan Stock diterima</span>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Pengaturan Website</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link @if($active == "Pengaturan Website") active @endif"
                        href="{{ route('config') }}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="fas fa-cogs"></i>
                            </span>
                        </span>
                        <span class="menu-title">Pengaturan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
    </div>
</div>
