 <!--begin::Main-->
 <x-arthemys.utils.multi-form name="collect_form" :steps="$registerSteps">
     <!-- Account Type -->
     @foreach ($registerSteps as $key => $item)
         @if ($item->status)
             <x-arthemys.utils.step step="{{ $item->step == 0 ? 'current' : '' }}">
                 <!--begin::Heading-->
                 @if ($item->show_info)
                     <x-arthemys.utils.step-header :title="$item->title" :subtitle="$item->description" />
                 @endif
                 <!--end::Heading-->
                 <!--begin::Input group-->
                 <div class="fv-row">
                     <!--begin::Row-->
                     <div class="row">
                         @foreach ($item->register_inputs as $key => $value)
                             @if ($value->type == 'face-cam')
                                 <livewire:arthemys.components.selfie-capture :use-ia="$value->ai_auto_verify" name="{{ $value->name }}" wire:model="formData.{{ $value->name }}" />
                             @elseif ($value->type == 'ip')
                                 <x-arthemys.form.ip-input name="{{ $value->name }}" :show-buttom="false"
                                     model="formData.{{ $value->name }}" />
                             @elseif ($value->type == 'location')
                                 <x-arthemys.form.location-input name="{{ $value->name }}" :show-buttom="false"
                                     model="formData.{{ $value->name }}" />
                             @elseif ($value->type == 'file')
                                 <x-arthemys.form.file-input name="{{ $value->name }}"
                                     placeholder="{{ $value->placeholder }}"
                                     wire:model="formData.{{ $value->name }}" />
                             @elseif ($value->type == 'hidden')
                                 <div class="col">
                                     <x-arthemys.form.text-input type="{{ $value->type }}" name="{{ $value->name }}"
                                         mask="{{ $value->mask }}" placeholder="{{ $value->placeholder }}"
                                         model="formData.{{ $value->name }}" label="{{ $value->label }}"
                                         required="{{ $value->required }}" />
                                 </div>
                             @elseif ($value->type == 'text')
                                 <div class="col-md-6">
                                     <x-arthemys.form.text-input type="{{ $value->type }}" name="{{ $value->name }}"
                                         mask="{{ $value->mask }}" placeholder="{{ $value->placeholder }}"
                                         wire:model="formData.{{ $value->name }}" label="{{ $value->label }}"
                                         required="{{ $value->required }}" />
                                 </div>
                             @elseif($value->type == 'email')
                                 <div class="col-md-6">
                                     <x-arthemys.form.text-input type="{{ $value->type }}" name="{{ $value->name }}"
                                         mask="{{ $value->mask }}" placeholder="{{ $value->placeholder }}"
                                         wire:model="formData.{{ $value->name }}" label="{{ $value->label }}"
                                         required="{{ $value->required }}" />
                                 </div>
                             @elseif($value->type == 'password')
                                 <div class="col-md-6">
                                     <x-arthemys.form.text-input type="{{ $value->type }}" name="{{ $value->name }}"
                                         mask="{{ $value->mask }}" placeholder="{{ $value->placeholder }}"
                                         wire:model="formData.{{ $value->name }}" label="{{ $value->label }}"
                                         required="{{ $value->required }}" />
                                 </div>
                             @elseif($value->type == 'select')
                                 <div class="col-md-6">
                                     <x-arthemys.form.simple-select-input name="{{ $value->name }}"
                                         wire:model="formData.{{ $value->name }}"
                                         placeholder="{{ $value->placeholder }}" label="{{ $value->label }}"
                                         required="{{ $value->required }}" :options="$value->options ?? []" />
                                 </div>
                             @elseif($value->type == 'checkbox')
                                 <div class="col-lg-6">
                                     <x-arthemys.form.card-select-input wire:model="formData.{{ $value->name }}"
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
                     </div>
                     <!--end::Row-->
                 </div>
                 <!--end::Input group-->
             </x-arthemys.utils.step>
         @endif
     @endforeach

     <!--begin::Actions-->
     <div class="d-flex flex-stack pt-15">
         <div class="mr-2">
             <button type="button" class="btn btn-lg btn-light-primary me-4" data-kt-stepper-action="previous">
                 <i class="ki-duotone ki-arrow-left fs-4 me-1">
                     <span class="path1"></span>
                     <span class="path2"></span>
                 </i> Anterior
             </button>
         </div>

         <div>
             <button wire:click='RegisterSubmit' type="button" class="btn btn-lg btn-primary"
                 data-kt-stepper-action="submit">
                 <span class="indicator-label">
                     Enviar
                     <i class="ki-duotone ki-arrow-right fs-4 ms-2">
                         <span class="path1"></span>
                         <span class="path2"></span>
                     </i>
                 </span>
                 <span class="indicator-progress">
                     Enviando...
                     <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                 </span>
             </button>

             <button wire:submit='CollectSteps' type="button" class="btn btn-lg btn-primary next-btn"
                 data-kt-stepper-action="next">
                 Continue
                 <i class="ki-duotone ki-arrow-right fs-4 ms-1">
                     <span class="path1"></span>
                     <span class="path2"></span>
                 </i>
             </button>
         </div>
     </div>
     <!--end::Actions-->
     <script>
         $(document).ready(() => {
             // Obter o step atual
             $('.next-btn').click(function(event) {
                 const currentStep = $(".current");
                 // Previne a ação padrão do botão "Continuar"
                 event.preventDefault();
                 // Procurar campos obrigatórios no step atual
                 const requiredFields = currentStep.find('[required]');

                 let allValid = true;

                 // Verificar cada campo obrigatório
                 requiredFields.each(function() {
                     if ($(this).val() === '' || $(this).val() === null) {
                         allValid = false;
                         $(this).addClass('is-invalid');
                     } else {
                         $(this).removeClass('is-invalid');
                     }
                 });

                 if (!allValid) {
                     // Exibe o alerta se houver campos não preenchidos
                     Swal.fire({
                         text: "Preencha todos os itens marcados como obrigatórios!",
                         icon: "warning",
                         buttonsStyling: false,
                         confirmButtonText: "Ok, entendi!",
                         customClass: {
                             confirmButton: "btn btn-light"
                         }
                     });

                     $('.next-btn').attr('disabled', true);
                 } else {
                     // Prosseguir para o próximo step
                     console.log('Tudo preenchido. Prosseguindo para o próximo step...');
                     //  currentStep.removeClass('current').next().addClass('current'); // Exemplo de navegação
                 }
             });

             // Remover o alerta de erro ao digitar no campo inválido
             $(document).on('input', '[required]', function() {
                 var inputs = $(".current").find('[required]');

                 if ($(this).val() !== '') {
                     $(this).removeClass('is-invalid');
                 }

                 for (var input of inputs) {
                     if (!$(input).val()) {
                         return $('.next-btn').attr('disabled', true);
                     }
                 }

                 return $('.next-btn').attr('disabled', false);
             });
         });
     </script>
 </x-arthemys.utils.multi-form>
 <!--end::Main-->
