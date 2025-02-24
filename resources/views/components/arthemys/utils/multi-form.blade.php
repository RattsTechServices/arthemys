 <!--begin::Authentication - Multi-steps-->
 <div class="d-flex flex-column flex-lg-row flex-column-fluid stepper stepper-pills stepper-light stepper-column"
     id="kt_create_account_stepper">
     <!--begin::Aside-->
     <div class="d-flex flex-column flex-lg-row-auto w-xl-400px positon-xl-relative bg-light  d-none d-sm-block">
         <!--begin::Wrapper-->
         <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-400px">
             <x-arthemys.utils.step-header-navigation>
                 <!--begin::Nav-->
                 <div class="stepper-nav">
                     @foreach ($steps as $key => $value)
                         @if ($value->status)
                             <x-arthemys.utils.step-navigation item="{{ $value->step }}" label="{{ $value->title }}"
                                 description="{{ $value->description }}" />
                         @endif
                     @endforeach
                 </div>
                 <!--end::Nav-->
             </x-arthemys.utils.step-header-navigation>

             <!--begin::Illustration-->
             <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-250px"
                 style="background-image: url(/public/assets/arthemys/media/illustrations/sigma-1/16.png)">
             </div>
             <!--end::Illustration-->
         </div>
         <!--end::Wrapper-->
     </div>
     <!--begin::Aside-->

     <!--begin::Body-->
     <div class="d-flex flex-column flex-lg-row-fluid py-10">
         <x-arthemys.utils.theme-switcher />
         <!--begin::Content-->
         <div class="d-flex flex-center flex-column flex-column-fluid">
             <!--begin::Logo-->
             @if (isset($system))
                 <a href="/" class="py-lg-0 d-block d-sm-none">
                     <img alt="Logo dark" src="{{ asset($system->logo_light) }}"
                         class="h-60px h-lg-70px show-in-light-mode" style="margin-bottom: 50px;">
                     <img alt="Logo light" src="{{ asset($system->logo_dark) }}"
                         class="h-60px h-lg-70px show-in-dark-mode" style="margin-bottom: 50px;">
                 </a>
             @endif
             <!--end::Logo-->
             <!--begin::Wrapper-->
             <div class="w-lg-700px p-10 p-lg-15 mx-auto">
                 <!--begin::Form-->
                 <form name="{{ $name }}" class="my-auto pb-5" novalidate="novalidate"
                     id="kt_create_account_form">
                     <!--begin::Step 1-->
                     {{ $slot }}
                     <!--end::Step 1-->
                 </form>
                 <!--end::Form-->
             </div>
             <!--end::Wrapper-->
         </div>
         <!--end::Content-->
         <!-- footer -->
         <x-arthemys.footer />
     </div>
     <!--end::Body-->
 </div>
 <!--end::Authentication - Multi-steps-->
