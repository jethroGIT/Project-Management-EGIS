<div
    class="aside card"
    data-kt-drawer="true"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-direction="start"
    data-kt-drawer-name="aside"
    data-kt-drawer-overlay="true"
    data-kt-drawer-toggle="#kt_aside_toggle"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}"
    id="kt_aside"
>
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid px-5">
        <!--begin::Aside Menu-->
        <div
            class="hover-scroll-overlay-y my-5 pe-4 me-n4"
            data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}"
            data-kt-scroll-dependencies="#kt_header, #kt_aside_footer"
            data-kt-scroll-height="auto"
            data-kt-scroll-offset="{lg: '75px'}"
            data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu"
            id="kt_aside_menu_wrapper"
        >
            <!--begin::Menu-->
            <div
                class="menu menu-column menu-rounded fw-bold fs-6"
                data-kt-menu="true"
                id="#kt_aside_menu"
            >
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span
                            class="menu-section text-muted text-uppercase fs-8 ls-1"
                            >Home</span
                        >
                    </div>
                </div>
                <div class="menu-item">
                    <a
                        class="menu-link active"
                        href="{{ route('dashboard') }}"
                    >
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
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
                                        height="9"
                                        rx="2"
                                        width="9"
                                        x="2"
                                        y="2"
                                    ></rect>
                                    <rect
                                        fill="black"
                                        height="9"
                                        opacity="0.3"
                                        rx="2"
                                        width="9"
                                        x="13"
                                        y="2"
                                    ></rect>
                                    <rect
                                        fill="black"
                                        height="9"
                                        opacity="0.3"
                                        rx="2"
                                        width="9"
                                        x="13"
                                        y="13"
                                    ></rect>
                                    <rect
                                        fill="black"
                                        height="9"
                                        opacity="0.3"
                                        rx="2"
                                        width="9"
                                        x="2"
                                        y="13"
                                    ></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span
                            class="menu-section text-muted text-uppercase fs-8 ls-1"
                            >Layanan Kelola</span
                        >
                    </div>
                </div>
                <div
                    class="menu-item menu-accordion"
                    data-kt-menu-trigger="click"
                >
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen055.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="black"/>
                                    <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="black"/>
                                    <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="black"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Task</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a
                                class="menu-link"
                                href="{{ route('perencanaan') }}"
                            >
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Perencanaan</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a
                                class="menu-link"
                                href="{{ route('realisasi') }}"
                            >
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Realisasi</span>
                            </a>
                        </div>
                    </div>
                </div>
            
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span
                            class="menu-section text-muted text-uppercase fs-8 ls-1"
                            >Board</span
                        >
                    </div>
                </div>
                
                <div class="menu-item">
                    <a
                        class="menu-link"
                        href="{{ route('kanban') }}"
                >
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M21 22H14C13.4 22 13 21.6 13 21V3C13 2.4 13.4 2 14 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z" fill="black"/>
                                    <path d="M10 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H10C10.6 2 11 2.4 11 3V21C11 21.6 10.6 22 10 22Z" fill="black"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Kanban</span>
                    </a>
                </div>
            </div>
            <!--end::Menu-->

        </div>
    </div>
    <!--end::Aside menu-->
    <!--begin::Footer-->
    <div
        class="aside-footer flex-column-auto pt-5 pb-7 px-5"
        id="kt_aside_footer"
    >
        <a
            class="btn btn-bg-light btn-color-gray-500 btn-active-color-gray-900 w-100"
            data-bs-dismiss-="click"
            data-bs-toggle="tooltip"
            data-bs-trigger="hover"
            href="../../demo14/dist/documentation/getting-started.html"
            title="200+ in-house components and 3rd-party plugins"
        >
            <span class="btn-label">Docs &amp; Components</span>
            <!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
            <span class="svg-icon btn-icon svg-icon-2">
                <svg
                    fill="none"
                    height="24"
                    viewbox="0 0 24 24"
                    width="24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z"
                        fill="black"
                        opacity="0.3"
                    ></path>
                    <rect
                        fill="black"
                        height="2"
                        rx="1"
                        width="6"
                        x="7"
                        y="17"
                    ></rect>
                    <rect
                        fill="black"
                        height="2"
                        rx="1"
                        width="10"
                        x="7"
                        y="12"
                    ></rect>
                    <rect
                        fill="black"
                        height="2"
                        rx="1"
                        width="6"
                        x="7"
                        y="7"
                    ></rect>
                    <path
                        d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z"
                        fill="black"
                    ></path>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </a>
    </div>
    <!--end::Footer-->
</div>
