<div wire:ignore x-data="{
    coords: '',
    getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                this.coords = '{{ $ip }}';
                console.log('End de ip capturado:', this.coords);
                $dispatch('update-coords', this.coords);
            }, error => {
                console.error('Erro ao obter localização:', error);
            });
        } else {
            console.error('Detecção de IP não suportada pelo navegador.');
        }
    }
}" x-init="getLocation()" @update-coords.window="@this.set('{{ $model }}', coords)">

    <input type="hidden" name="{{ $name }}" x-model="coords" wire:model='{{ $model }}' {{ $attributes }} />

    @if ($showButtom)
        <button type="button" class="btn btn-primary" @click="getLocation">Atualizar Localização</button>
    @endif
</div>
