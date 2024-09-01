<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('Dashboard.Index') }}">
            <img alt="Logo" src="{{ asset('assets/custom/media/logo_dark.svg') }}" class="h-45px app-sidebar-logo-default theme-dark-show"/>
            <img alt="Logo" src="{{ asset('assets/custom/media/logo.svg') }}" class="h-45px app-sidebar-logo-default theme-light-show"/>
            <img alt="Logo" src="{{ asset('assets/custom/media/default-small-dark.svg') }}" class="h-20px app-sidebar-logo-minimize"/>
        </a>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    <div data-kt-menu-trigger="click"  class="menu-item here show menu-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ (request()->is('/' )) ? 'active' : '' }}" href="{{ route('Dashboard.Index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-house-check-fill fs-2" style="padding-top: 1px;"></i>
                            </span>
                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.01') }}</span>
                            </a>
                        </div>

                        @if(Auth()->user()->can('Kullanıcıları Görüntüleme') or Auth()->user()->can('Kullanıcı Rollerini Görüntüleme') or Auth()->user()->can('Kullanıcı İzinlerini Görüntüleme') or Auth()->user()->can('Kullanıcı Hareketlerini Görüntüleme'))
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->is('users', 'users/create', 'users/*/edit', 'roles', 'roles/create', 'roles/*/edit', 'permissions', 'permissions/create', 'permissions/*/edit', 'activitylogs')) ? 'here show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-solid ki-gear fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.02') }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion">
                                @can('Kullanıcıları Görüntüleme')
                                <div class="menu-item">
                                    <a class="menu-link {{ (request()->is('users', 'users/create', 'users/*/edit')) ? 'active' : '' }}" href="{{ route('Users.Index') }}" style="padding: 0.25rem 1rem;">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">{{ __('messages.partial.sidebar.menu.02.01') }}</span>
                                    </a>
                                </div>
                                @endcan
                                @can('Kullanıcı Rollerini Görüntüleme')
                                <div class="menu-item">
                                    <a class="menu-link {{ (request()->is('roles', 'roles/create', 'roles/*/edit')) ? 'active' : '' }}" href="{{ route('Roles.Index') }}" style="padding: 0.25rem 1rem;">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">{{ __('messages.partial.sidebar.menu.02.02') }}</span>
                                    </a>
                                </div>
                                @endcan
                                @can('Kullanıcı İzinlerini Görüntüleme')
                                <div class="menu-item">
                                    <a class="menu-link {{ (request()->is('permissions', 'permissions/create', 'permissions/*/edit')) ? 'active' : '' }}" href="{{ route('Permissions.Index') }}" style="padding: 0.25rem 1rem;">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">{{ __('messages.partial.sidebar.menu.02.03') }}</span>
                                    </a>
                                </div>
                                @endcan
                                @can('Kullanıcı Hareketlerini Görüntüleme')
                                <div class="menu-item">
                                    <a class="menu-link {{ (request()->is('activitylogs')) ? 'active' : '' }}" href="{{ route('ActivityLogs.Index') }}" style="padding: 0.25rem 1rem;">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">{{ __('messages.partial.sidebar.menu.02.05') }}</span>
                                    </a>
                                </div>
                                @endcan
                            </div>
                        </div>
                        @endif

                        @if(Auth()->user()->can('Müşterileri Görüntüleme'))
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->is('clients', 'clients/create', 'clients/*/edit', 'clients/*/moduleselection', 'clients/*/extensionselection')) ? 'here show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-solid ki-security-user fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.03') }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion">
                                @can('Müşterileri Görüntüleme')
                                <div class="menu-item">
                                    <a class="menu-link {{ (request()->is('clients', 'clients/create', 'clients/*/edit', 'clients/*/serverconnection', 'clients/*/moduleselection', 'clients/*/extensionselection')) ? 'active' : '' }}" href="{{ route('Clients.Index') }}" style="padding: 0.25rem 1rem;">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">{{ __('messages.partial.sidebar.menu.03.01') }}</span>
                                    </a>
                                </div>
                                @endcan
                            </div>
                        </div>
                        @endif

                        @if(Auth()->user()->can('Şirket Bilgilerini Görüntüleme') or Auth()->user()->can('Personelleri Görüntüleme') or Auth()->user()->can('Organizasyon Şeması Görüntüleme'))
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->is('organizationchart', 'companydetails', 'employees', 'employees/create', 'employees/*/edit', 'employeelogs')) ? 'here show' : '' }}">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-solid ki-profile-user fs-2"></i>
                                    </span>
                                    <span class="menu-title">{{ __('messages.partial.sidebar.menu.06') }}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion">
                                    @can('Şirket Bilgilerini Görüntüleme')
                                        <div class="menu-item">
                                            <a class="menu-link {{ (request()->is('companydetails')) ? 'active' : '' }}" href="{{ route('CompanyDetails.Index') }}" style="padding: 0.25rem 1rem;">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.06.01') }}</span>
                                            </a>
                                        </div>
                                    @endcan
                                    @can('Personelleri Görüntüleme')
                                        <div class="menu-item">
                                            <a class="menu-link {{ (request()->is('employees', 'employees/create', 'employees/*/edit')) ? 'active' : '' }}" href="{{ route('Employees.Index') }}" style="padding: 0.25rem 1rem;">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.06.02') }}</span>
                                            </a>
                                        </div>
                                    @endcan
                                    @can('Organizasyon Şeması Görüntüleme')
                                        <div class="menu-item">
                                            <a class="menu-link {{ (request()->is('organizationchart')) ? 'active' : '' }}" href="{{ route('OrganizationCharts.Index') }}" style="padding: 0.25rem 1rem;">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title text-warning">{{ __('messages.partial.sidebar.menu.06.03') }}</span>
                                            </a>
                                        </div>
                                    @endcan
                                    @can('Personel Hareketlerini Görüntüleme')
                                        <div class="menu-item">
                                            <a class="menu-link {{ (request()->is('employeelogs')) ? 'active' : '' }}" href="{{ route('EmployeeLogs.Index') }}" style="padding: 0.25rem 1rem;">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.06.04') }}</span>
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @endif

                        @if(Auth()->user()->can('Duyuruları Görüntüleme'))
                            <div class="menu-item">
                                <a class="menu-link {{ (request()->is('announcements', 'announcements/create', 'announcements/*/edit')) ? 'active' : '' }}" href="{{ route('Announcements.Index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-app-indicator fs-3" style="padding-top: 1px;"></i>
                            </span>
                                    <span class="menu-title">{{ __('messages.partial.sidebar.menu.95') }}</span>
                                </a>
                            </div>
                        @endif

                        @if(Auth()->user()->can('Call Center Müşterilerini Görüntüleme') or Auth()->user()->can('Dış Hat Numaralarımı Görüntüleme') or Auth()->user()->can('Dahili Numaralarımı Görüntüleme') or Auth()->user()->can('Data Yönetimi Görüntüleme'))
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->is('callcenterclients', 'callcenterclients/create', 'callcenterclients/*/edit', 'mynumbers', 'myextensions', 'datamanagement', 'datadistribution', 'callorderdetails/*')) ? 'here show' : '' }}">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-solid ki-scan-barcode fs-2"></i>
                                    </span>
                                    <span class="menu-title">{{ __('messages.partial.sidebar.menu.04') }}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion">
                                    @can('Call Center Müşterilerini Görüntüleme')
                                    <div class="menu-item">
                                        <a class="menu-link {{ (request()->is('callcenterclients', 'callcenterclients/create', 'callcenterclients/*/edit', 'callorderdetails/*')) ? 'active' : '' }}" href="{{ route('CallCenterClients.Index') }}" style="padding: 0.25rem 1rem;">
                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                            <span class="menu-title">{{ __('messages.partial.sidebar.menu.04.01') }}</span>
                                        </a>
                                    </div>
                                    @endcan
                                    @can('Dış Hat Numaralarımı Görüntüleme')
                                    <div class="menu-item">
                                        <a class="menu-link {{ (request()->is('mynumbers')) ? 'active' : '' }}" href="{{ route('MyNumbers.Index') }}" style="padding: 0.25rem 1rem;">
                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                            <span class="menu-title">{{ __('messages.partial.sidebar.menu.04.02') }}</span>
                                        </a>
                                    </div>
                                    @endcan
                                    @can('Dahili Numaralarımı Görüntüleme')
                                    <div class="menu-item">
                                        <a class="menu-link {{ (request()->is('myextensions')) ? 'active' : '' }}" href="{{ route('MyExtensions.Index') }}" style="padding: 0.25rem 1rem;">
                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                            <span class="menu-title">{{ __('messages.partial.sidebar.menu.04.03') }}</span>
                                        </a>
                                    </div>
                                    @endcan
                                    @can('Data Yönetimi Görüntüleme')
                                    <div class="menu-item">
                                        <a class="menu-link {{ (request()->is('datamanagement')) ? 'active' : '' }}" href="{{ route('DataManagement.Index') }}" style="padding: 0.25rem 1rem;">
                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                            <span class="menu-title">{{ __('messages.partial.sidebar.menu.04.04') }}</span>
                                        </a>
                                    </div>
                                    @endcan
                                    @can('Data Dağıtımı Görüntüleme')
                                        <div class="menu-item">
                                            <a class="menu-link {{ (request()->is('datadistribution')) ? 'active' : '' }}" href="{{ route('DataDistribution.Index') }}" style="padding: 0.25rem 1rem;">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.04.05') }}</span>
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @endif

                        @if(Auth()->user()->can('Ödeme Periyotlarını Görüntüleme') or Auth()->user()->can('Ödeme Emirlerini Görüntüleme') or Auth()->user()->can('Faturalarımı Görüntüleme') or Auth()->user()->can('Hizmet Fiyatlarını Görüntüleme'))
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->is('myinvoices', 'myinvoices/*', 'paymentperiods', 'paymentperiods/create', 'paymentperiods/*/edit', 'paymentorders', 'paymentorders/create', 'paymentorders/*/edit', 'servicefees')) ? 'here show' : '' }}">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-solid ki-finance-calculator fs-2"></i>
                                    </span>
                                    <span class="menu-title">{{ __('messages.partial.sidebar.menu.07') }}</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion">
                                    @can('Ödeme Periyotlarını Görüntüleme')
                                    <div class="menu-item">
                                        <a class="menu-link {{ (request()->is('paymentperiods', 'paymentperiods/create', 'paymentperiods/*/edit')) ? 'active' : '' }}" href="{{ route('PaymentPeriods.Index') }}" style="padding: 0.25rem 1rem;">
                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                            <span class="menu-title">{{ __('messages.partial.sidebar.menu.07.01') }}</span>
                                        </a>
                                    </div>
                                    @endcan
                                    @can('Ödeme Emirlerini Görüntüleme')
                                    <div class="menu-item">
                                        <a class="menu-link {{ (request()->is('myinvoices', 'myinvoices/*', 'paymentorders', 'paymentorders/create', 'paymentorders/*/edit')) ? 'active' : '' }}" href="{{ route('PaymentOrders.Index') }}" style="padding: 0.25rem 1rem;">
                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                            <span class="menu-title">{{ __('messages.partial.sidebar.menu.07.02') }}</span>
                                        </a>
                                    </div>
                                    @endcan
                                    @can('Faturalarımı Görüntüleme')
                                    <div class="menu-item">
                                        <a class="menu-link {{ (request()->is('myinvoices', 'myinvoices/*')) ? 'active' : '' }}" href="{{ route('MyInvoices.Index') }}" style="padding: 0.25rem 1rem;">
                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                            <span class="menu-title">{{ __('messages.partial.sidebar.menu.07.03') }}</span>
                                        </a>
                                    </div>
                                    @endcan
                                    @can('Hizmet Fiyatlarını Görüntüleme')
                                        <div class="menu-item">
                                            <a class="menu-link {{ (request()->is('servicefees')) ? 'active' : '' }}" href="{{ route('ServiceFees.Index') }}" style="padding: 0.25rem 1rem;">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.07.04') }}</span>
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @endif

                        @if(Auth()->user()->can('SMS Cihazlarını Görüntüleme') or Auth()->user()->can('SMS Bakiye Modülü Görüntüleme'))
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->is('smsdevices', 'smsdevices/create', 'smsdevices/*/edit', 'smscredits')) ? 'here show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-solid ki-wallet fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.10') }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                                <div class="menu-sub menu-sub-accordion">
                                    @can('SMS Cihazlarını Görüntüleme')
                                        <div class="menu-item">
                                            <a class="menu-link {{ (request()->is('smsdevices', 'smsdevices/create', 'smsdevices/*/edit')) ? 'active' : '' }}" href="{{ route('SMSDevices.Index') }}" style="padding: 0.25rem 1rem;">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.10.01') }}</span>
                                            </a>
                                        </div>
                                    @endcan
                                    @can('SMS Bakiye Modülü Görüntüleme')
                                        <div class="menu-item">
                                            <a class="menu-link {{ (request()->is('smscredits')) ? 'active' : '' }}" href="{{ route('SMSCredits.Index') }}" style="padding: 0.25rem 1rem;">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.10.02') }}</span>
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @endif

                        @if(Auth()->user()->can('Arama Emirlerini Görüntüleme'))
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->is('callorders', 'callorderdetails/*')) ? 'here show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="bi bi-telephone-outbound-fill fs-4" style="padding-top: 1px;"></i>
                                </span>
                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.08') }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                                <div class="menu-sub menu-sub-accordion">
                                    @can('Arama Emirlerini Görüntüleme')
                                        <div class="menu-item">
                                            <a class="menu-link {{ (request()->is('callorders', 'callorderdetails/*')) ? 'active' : '' }}" href="{{ route('CallOrders.Index') }}" style="padding: 0.25rem 1rem;">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.08.01') }}</span>
                                                @if($isNewAssigns && $newAssignedNumberCount > 0)
                                                    <span class="menu-badge"><span class="badge badge-success badge-sm" style="padding-top: -1px;">{{ $newAssignedNumberCount }}</span></span>
                                                @endif
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @endif

                        <div class="menu-item">
                            <a class="menu-link {{ (request()->is('myannouncements')) ? 'active' : '' }}" href="{{ route('MyAnnouncements.Index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-bell-fill fs-3" style="padding-top: 1px;"></i>
                            </span>
                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.94') }}</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link {{ (request()->is('contact')) ? 'active' : '' }}" href="{{ route('Contact.Index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-question-diamond-fill fs-3" style="padding-top: 1px;"></i>
                            </span>
                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.93') }}</span>
                            </a>
                        </div>

                        @if(Auth()->user()->can('Genel Ayarları Düzenleme') or Auth()->user()->can('Sistem Ayarlarını Düzenleme'))
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (request()->is('systemsettings', 'generalsettings')) ? 'here show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-solid ki-gear fs-2"></i>
                                </span>
                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.96') }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion">
                                @can('Genel Ayarları Düzenleme')
                                <div class="menu-item">
                                    <a class="menu-link {{ (request()->is('generalsettings')) ? 'active' : '' }}" href="{{ route('GeneralSettings.Index') }}" style="padding: 0.25rem 1rem;">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">{{ __('messages.partial.sidebar.menu.97') }}</span>
                                    </a>
                                </div>
                                @endcan
                                @can('Sistem Ayarlarını Düzenleme')
                                <div class="menu-item">
                                    <a class="menu-link {{ (request()->is('systemsettings')) ? 'active' : '' }}" href="{{ route('SystemSettings.Index') }}" style="padding: 0.25rem 1rem;">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">{{ __('messages.partial.sidebar.menu.98') }}</span>
                                    </a>
                                </div>
                                @endcan
                            </div>
                        </div>
                        @endif



                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="menu-icon">
                                <i class="bi bi-x-octagon-fill fs-3" style="padding-top: -4px;"></i>
                            </span>
                                <span class="menu-title">{{ __('messages.partial.sidebar.menu.99') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <a href="#" class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100">
            <span class="btn-label">{{ __('messages.partial.sidebar.01') }}</span>
            <i class="ki-solid ki-document btn-icon fs-2 m-0"></i>
        </a>
    </div>
</div>
