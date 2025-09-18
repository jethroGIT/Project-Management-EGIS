<div class="header" id="kt_header">
    <!--begin::Container-->
    <div class="container-fluid d-flex flex-stack">
        <!--begin::Brand-->
        <div class="d-flex align-items-center me-5">
            <!--begin::Aside toggle-->
            <div
                class="d-lg-none btn btn-icon btn-active-color-white w-30px h-30px ms-n2 me-3"
                id="kt_aside_toggle"
            >
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="svg-icon svg-icon-2">
                    <svg
                        fill="none"
                        height="24"
                        viewbox="0 0 24 24"
                        width="24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                            fill="black"
                        ></path>
                        <path
                            d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                            fill="black"
                            opacity="0.3"
                        ></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Aside  toggle-->
            <!--begin::Logo-->
            <a href="../../demo14/dist/index.html">
                <img
                    alt="Logo"
                    class="h-25px h-lg-30px"
                    src="{{ asset('assets/media/logos/logo-2.svg') }}"
                />
            </a>
            <!--end::Logo-->
            <!--begin::Nav-->
            {{-- <div class="ms-5 ms-md-10">
                <!--begin::Toggle-->
                <button
                    class="btn btn-flex btn-active-color-white align-items-cenrer justify-content-center justify-content-md-between align-items-lg-cenrer flex-md-content-between bg-white bg-opacity-10 btn-color-gray-500 px-0 ps-md-6 pe-md-5 h-30px w-30px h-md-35px w-md-200px"
                    data-kt-menu-placement="bottom-start"
                    data-kt-menu-trigger="click"
                    type="button"
                >
                    <span class="d-none d-md-inline">Dashboard</span>
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                    <span class="svg-icon svg-icon-4 ms-md-4 me-0">
                        <svg
                            fill="none"
                            height="24"
                            viewbox="0 0 24 24"
                            width="24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                fill="black"
                            ></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </button>
                <!--end::Toggle-->
                <!--begin::Menu-->
                <div
                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg fw-bold w-200px pb-3"
                    data-kt-menu="true"
                >
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div
                            class="menu-content fs-7 text-dark fw-bolder px-3 py-4"
                        >
                            Select department:
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator mb-3 opacity-75"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a class="menu-link px-3" href="#"
                            >Accounting &amp; Finance</a
                        >
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
            </div> --}}
            <!--end::Nav-->
        </div>
        <!--end::Brand-->
        <!--begin::Topbar-->
        <div class="d-flex align-items-center">
            <!--begin::Topbar-->
            <div class="d-flex align-items-center flex-shrink-0">
                <!--begin::Search-->
                <div
                    class="d-flex align-items-stretch"
                    data-kt-menu-overflow="false"
                    data-kt-menu-permanent="true"
                    data-kt-menu-placement="bottom-end"
                    data-kt-menu-trigger="auto"
                    data-kt-search-enter="enter"
                    data-kt-search-keypress="true"
                    data-kt-search-layout="menu"
                    data-kt-search-min-length="2"
                    id="kt_header_search"
                >
                    <!--begin::Search toggle-->
                    <div
                        class="d-flex align-items-center"
                        data-kt-search-element="toggle"
                        id="kt_header_search_toggle"
                    >
                        <div
                            class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-30px h-30px h-40px w-40px"
                        >
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg
                                    fill="none"
                                    height="24"
                                    viewbox="0 0 24 24"
                                    width="24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <rect
                                        fill="black"
                                        height="2"
                                        opacity="0.5"
                                        rx="1"
                                        transform="rotate(45 17.0365 15.1223)"
                                        width="8.15546"
                                        x="17.0365"
                                        y="15.1223"
                                    ></rect>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"
                                    ></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <!--end::Search toggle-->
                    <!--begin::Menu-->
                    <div
                        class="menu menu-sub menu-sub-dropdown p-3 w-200px w-md-250px" 
                        data-kt-search-element="content">
                        <!--begin::Wrapper-->
                        <div data-kt-search-element="wrapper">
                            <!--begin::Form-->
                            <form
                                autocomplete="off"
                                class="w-100 position-relative mb-2"
                                data-kt-search-element="form"
                            >
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span
                                    class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 translate-middle-y ms-0"
                                >
                                    <svg
                                        fill="none"
                                        height="24"
                                        viewbox="0 0 24 24"
                                        width="24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <rect
                                            fill="black"
                                            height="2"
                                            opacity="0.5"
                                            rx="1"
                                            transform="rotate(45 17.0365 15.1223)"
                                            width="8.15546"
                                            x="17.0365"
                                            y="15.1223"
                                        ></rect>
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="black"
                                        ></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Input-->
                                <input
                                    class="form-control form-control-flush ps-10 py-1" 
                                    data-kt-search-element="input"
                                    name="search"
                                    placeholder="Search..."
                                    type="text"
                                    value=""
                                    style="font-size: 0.9rem;"
                                />
                                <!--end::Input-->
                                <!--begin::Spinner-->
                                <span
                                    class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1"
                                    data-kt-search-element="spinner"
                                >
                                    <span
                                        class="spinner-border h-10px w-10px align-middle text-gray-400" 
                                    ></span>
                                </span>
                                <!--end::Spinner-->
                                <!--begin::Reset-->
                                <span
                                    class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none"
                                    data-kt-search-element="clear"
                                >
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span
                                        class="svg-icon svg-icon-2 svg-icon-lg-1 me-0"
                                    >
                                        <svg
                                            fill="none"
                                            height="24"
                                            viewbox="0 0 24 24"
                                            width="24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <rect
                                                fill="black"
                                                height="2"
                                                opacity="0.5"
                                                rx="1"
                                                transform="rotate(-45 6 17.3137)"
                                                width="16"
                                                x="6"
                                                y="17.3137"
                                            ></rect>
                                            <rect
                                                fill="black"
                                                height="2"
                                                rx="1"
                                                transform="rotate(45 7.41422 6)"
                                                width="16"
                                                x="7.41422"
                                                y="6"
                                            ></rect>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <!--end::Reset-->                                
                            </form>
                            <!--end::Form-->
                            <!--begin::Empty-->
                            <div
                                class="text-center d-none"
                                data-kt-search-element="empty"
                            >                            
                            </div>
                            <!--end::Empty-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Search-->
                <!--begin::User-->
                <div
                    class="d-flex align-items-center ms-1"
                    id="kt_header_user_menu_toggle"
                >
                    <!--begin::User info-->
                    <div
                        class="btn btn-flex align-items-center bg-hover-white bg-hover-opacity-10 py-2 px-2 px-md-3"
                        data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end"
                        data-kt-menu-trigger="click"
                    >
                        <!--begin::Name-->
                        <div
                            class="d-none d-md-flex flex-column align-items-end justify-content-center me-2 me-md-4"
                        >
                            <span class="text-white fs-8 fw-bolder lh-1 mb-1"
                                >{{auth()->user()->name ?? '-'}}</span
                            >
                            <span class="text-muted fs-8 fw-bold lh-1">
                                @php
                                    $roles = auth()->user()->getRoleNames();
                                @endphp
                                {{ $roles->get(1) ? '' : ($roles->first() ?? '-') }}</span
                            >
                        </div>
                        <!--end::Name-->
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px symbol-md-40px">
                            <img
                                alt="image"
                                src="{{ asset('assets/media/svg/avatars/blank.svg') }}"
                            />
                        </div>
                        <!--end::Symbol-->
                    </div>
                    <!--end::User info-->
                    <!--begin::Menu-->
                    <div
                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6"
                        data-kt-menu="true"
                        style="width:auto; min-width:275px;"
                    >
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div
                                class="menu-content d-flex align-items-center px-3"
                            >
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img
                                        alt="Logo"
                                        src="{{ asset('assets/media/svg/avatars/blank-dark.svg') }}"
                                    />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div
                                        class="fw-bolder d-flex align-items-center fs-5"
                                    >
                                        {{auth()->user()->name ?? '-'}}
                                    </div>
                                    <a
                                        class="fw-bold text-muted text-hover-primary fs-7"
                                        href="#"
                                        >{{auth()->user()->email ?? '-'}}</a
                                    >
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a
                                class="menu-link px-5"
                                href="{{route('profile')}}"
                                >My Profile</a
                            >
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a
                                class="menu-link px-5"
                                href="../../demo14/dist/apps/projects/list.html"
                            >
                                <span class="menu-text">My Projects</span>
                                <span class="menu-badge">
                                    <span
                                        class="badge badge-light-danger badge-circle fw-bolder fs-7"
                                        >3</span
                                    >
                                </span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button
                                    type="submit"
                                    class="menu-link px-5 bg-transparent border-0"
                                    style="background:none;border:none;padding:0;font-weight:500;"
                                >
                                    Sign Out
                                </button>
                            </form>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::User -->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
