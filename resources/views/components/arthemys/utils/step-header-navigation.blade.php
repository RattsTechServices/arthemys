<!--begin::Header-->
<div class="d-flex flex-row-fluid flex-column align-items-center align-items-lg-start p-lg-20">
    <!--begin::Logo-->
    @if (isset($system))
        <a href="/" class="py-lg-0">
            <img alt="Logo light" src="{{ asset($system->logo_light) }}" class="h-60px h-lg-70px show-in-light-mode"
                style="margin-bottom: 50px;">
            <img alt="Logo dark" src="{{ asset($system->logo_dark) }}" class="h-60px h-lg-70px show-in-dark-mode"
                style="margin-bottom: 50px;">
        </a>
    @endif
    <!--end::Logo-->
    {{ $slot }}
</div>
<!--end::Header-->
