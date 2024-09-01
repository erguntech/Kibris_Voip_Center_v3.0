<div class="page-loader flex-column">
    <img alt="Logo" class="theme-light-show max-h-50px" src="{{ asset('assets/custom/media/loader_logo.svg') }}" width="175"/>
    <img alt="Logo" class="theme-dark-show max-h-50px" src="{{ asset('assets/custom/media/loader_logo_dark.svg') }}" width="175"/>
    <div class="d-flex align-items-center mt-5">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-muted fs-6 fw-semibold ms-5">{{ __('messages.partial.loader.01') }}</span>
    </div>
</div>
