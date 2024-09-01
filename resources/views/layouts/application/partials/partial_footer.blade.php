<div id="kt_app_footer" class="app-footer">
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-gray-900 order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">{{ date('Y') }}&copy;</span>
            <a href="{{ route('Dashboard.Index') }}" class="text-gray-800 text-hover-primary">{{ Settings::get('app_title') }} - {{ Settings::get('app_version') }}</a>
        </div>
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item"><a href="" class="menu-link px-2">{{ __('messages.partial.footer.01') }}</a></li>
            <li class="menu-item"><a href="{{ route('Contact.Index') }}" class="menu-link px-2">{{ __('messages.partial.footer.02') }}</a></li>
            <li class="menu-item"><a href="{{ route('Contact.Index') }}" class="menu-link px-2">{{ __('messages.partial.footer.03') }}</a></li>
        </ul>
    </div>
</div>
