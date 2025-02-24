<div class="col-md-12">
    <!--begin::Option-->
    <input type="radio" class="btn-check" {{ $attributes }} name="{{ $name }}"
        value="{{ $value }}" {{ $required == true ? 'required' : '' }} {{ $checked == true ? 'checked' : '' }}
        id="{{ $label }}" />
    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex align-items-center mb-10 text-truncate"
        for="{{ $label }}" style="padding: 20px;">
        {{ $slot }}
        <!--begin::Info-->
        <span class="d-block fw-semibold text-start">
            <div class="text-dark fw-bold d-block fs-4 mb-2 ms-3 {{ $required == true ? 'required' : '' }}">
                {{ $title }}
            </div>
            <div class="text-muted fw-semibold fs-6 ms-3 text-truncate" style="max-width: 100%;">
                {{ $subtitle }}
            </div>
        </span>
        <!--end::Info-->
    </label>
    <!--end::Option-->
</div>
