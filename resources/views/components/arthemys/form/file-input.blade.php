<div class="mb-10 fv-row ">
    <label class="form-label mb-3 {{ $required == true ? 'required' : '' }}">{{ $label }}</label>

    <div x-data="{
        file: null,
        previewUrl: null,
        handleFileChange(event) {
            const file = event.target.files[0] || event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                this.file = file;
                this.previewUrl = URL.createObjectURL(file);
            } else {
                alert('Por favor, selecione um arquivo de imagem válido.');
            }
        },
        removeFile() {
            this.file = null;
            this.previewUrl = null;
        }
    }" class="text-center">

        <label for="fileInput"
            class="border border-primary border-dashed rounded p-4 d-flex flex-column align-items-center justify-content-center"
            style="cursor: pointer; min-height: 150px;" @dragover.prevent @drop.prevent="handleFileChange">

            <div x-show="!file" class="text-muted">
                {{ $placeholder }}
            </div>
            <input type="file" id="fileInput" name="{{$name}}" class="d-none" accept="image/*"
                @change="handleFileChange" {{ $attributes }} {{ $required == true ? 'required' : '' }} />

            <template x-if="previewUrl">
                <div class="position-relative mt-2">
                    <img :src="previewUrl" alt="Preview" class="img-thumbnail"
                        style="max-width: 200px; max-height: 200px;">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0"
                        @click="removeFile">&times;</button>
                </div>
            </template>
        </label>
    </div>
</div>
