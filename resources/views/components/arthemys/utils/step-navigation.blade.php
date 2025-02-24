 <!--begin::Step 1-->
 <div class="stepper-item current" data-kt-stepper-element="nav">
    <!--begin::Wrapper-->
    <div class="stepper-wrapper">
        <!--begin::Icon-->
        <div class="stepper-icon rounded-3">
            <i class="stepper-check fas fa-check"></i>
            <span class="stepper-number">{{$item}}</span>
        </div>
        <!--end::Icon-->

        <!--begin::Label-->
        <div class="stepper-label">
            <h3 class="stepper-title fs-2">
                {{$label}}
            </h3>

            <div class="stepper-desc fw-normal">
                {{$description}}
            </div>
        </div>
        <!--end::Label-->
    </div>
    <!--end::Wrapper-->

    <!--begin::Line-->
    <div class="stepper-line h-40px">
    </div>
    <!--end::Line-->
</div>
<!--end::Step 1-->