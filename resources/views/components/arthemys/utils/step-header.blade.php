<div class="pb-10 pb-lg-15">
    <!--begin::Title-->
    <h2 class="fw-bold d-flex align-items-center text-dark">
        {{ $title }}
        @if ($tooltipInfo)
            <span class="ms-1" data-bs-toggle="tooltip" title="{{$tooltipInfo}}">
                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
            </span>
        @endif
    </h2>
    <!--end::Title-->

    <!--begin::Notice-->
    <div class="text-muted fw-semibold fs-6">
        {{ $subtitle }}
    </div>
    <!--end::Notice-->
</div>
