<!--begin::Authentication - Sign-in -->
<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Aside-->
    <div class="d-flex flex-column flex-lg-row-auto bg-light w-xl-600px positon-xl-relative">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
            <!--begin::Header-->
            <div class="d-flex flex-row-fluid flex-column text-center p-5 p-lg-10 pt-lg-20">
                <!--begin::Logo-->
                <a href="/" class="py-5 py-lg-20">
                    <img alt="Logo dark" src="{{ asset($system->logo_light) }}"
                        class="h-60px h-lg-70px show-in-light-mode">
                    <img alt="Logo light" src="{{ asset($system->logo_dark) }}"
                        class="h-60px h-lg-70px show-in-dark-mode">
                </a>
                <!--end::Logo-->

                <!--begin::Title-->
                <h1 class="d-none d-lg-block fw-bold text-dark fs-2qx mt-5">
                    {{ $system->title }}
                </h1>
                <!--end::Title-->

                <!--begin::Description-->
                <p class="d-none d-lg-block fw-semibold fs-2 text-dark">
                    {{ $system->description }}
                </p>
                <!--end::Description-->
            </div>
            <!--end::Header-->

            <!--begin::Illustration-->
            <div class="d-none d-lg-block d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                style="background-image: url(/craft/assets/media/illustrations/sigma-1/17.png)">
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
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10 p-lg-15 mx-auto">

                <!--begin::Form-->
                <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate"
                    id="kt_sign_in_form" data-kt-redirect-url="#" action="#">
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">
                            Seja Bem-vindo!
                        </h1>
                        <!--end::Title-->

                        <!--begin::Link-->
                        <div class="text-gray-400 fw-semibold fs-4">
                            Vamos iniciar o processo de cadastro.
                        </div>
                        <!--end::Link-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Content-->
                    @if (isset($initialRegisterInputs))
                        @foreach ($initialRegisterInputs as $key => $value)
                            @if ($value->type == 'text')
                                <div class="col">
                                    <x-arthemys.form.text-input type="{{ $value->type }}" name="{{ $value->name }}"
                                        mask="{{ $value->mask }}" placeholder="{{ $value->placeholder }}"
                                        model="reference.{{ $value->name }}" label="{{ $value->label }}"
                                        required="{{ $value->required }}" />
                                </div>
                            @elseif($value->type == 'email')
                                <div class="col">
                                    <x-arthemys.form.text-input type="{{ $value->type }}" name="{{ $value->name }}"
                                        mask="{{ $value->mask }}" placeholder="{{ $value->placeholder }}"
                                        wire:model="reference.{{ $value->name }}" label="{{ $value->label }}"
                                        required="{{ $value->required }}" />
                                </div>
                            @elseif($value->type == 'password')
                                <div class="col">
                                    <x-arthemys.form.text-input type="{{ $value->type }}" name="{{ $value->name }}"
                                        mask="{{ $value->mask }}" placeholder="{{ $value->placeholder }}"
                                        model="reference.{{ $value->name }}" label="{{ $value->label }}"
                                        required="{{ $value->required }}" />
                                </div>
                            @elseif($value->type == 'select')
                                <div class="col">
                                    <x-arthemys.form.simple-select-input name="{{ $value->name }}"
                                        model="reference.{{ $value->name }}" placeholder="{{ $value->placeholder }}"
                                        label="{{ $value->label }}" required="{{ $value->required }}"
                                        :options="$value->options ?? []" />
                                </div>
                            @elseif($value->type == 'checkbox')
                                <div class="col-lg-6">
                                    <x-arthemys.form.card-select-input model="reference.{{ $value->name }}"
                                        :required="$value->required" :name="$value->name" :value="$value->value" :title="$value->label"
                                        :subtitle="$value->placeholder" :label="$value->name . '_id_' . $key" :checked="false">
                                        {!! $value->icon !!}
                                    </x-arthemys.form.card-select-input>
                                </div>
                            @elseif($value->type == 'card')
                                <div class="col-lg-12 card p-3 shadow mb-3">
                                    {!! $value->html !!}
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <!--end::Content-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button wire:click="CollectEmail" type="button" id="kt_sign_in_submit"
                            class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">
                                Continue
                            </span>

                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Submit button-->
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
        <!-- footer -->
        {{-- <x-afrodite.footer /> --}}
    </div>
    <!--end::Body-->
</div>
<!--end::Authentication - Sign-in-->
