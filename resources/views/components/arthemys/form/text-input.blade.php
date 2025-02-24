<!--begin::Input group-->
<div class="mb-10 fv-row {{ $type == "hidden" ? 'd-none' : '' }}">
    <!--begin::Label-->
    @if ($type !== 'hidden')
        <label class="form-label mb-3 {{ $required == true ? 'required' : '' }}">{{ $label }}</label>
    @endif
    <!--end::Label-->

    <!--begin::Input-->
    <input type="{{ $type }}" class="form-control form-control-lg form-control-solid" name="{{ $name }}" x-mask="{{ $mask }}" placeholder="{{ $placeholder }}" {{ $required == true ? 'required' : '' }} {{ $attributes }} />
    <!--end::Input-->
</div>
<!--end::Input group-->
