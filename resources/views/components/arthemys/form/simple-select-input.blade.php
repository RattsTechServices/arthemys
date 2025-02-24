<!--begin::Input group-->
<div class="fv-row mb-10">
    <label class="form-label {{ $required == true ? 'required' : '' }}">
        {{ $label }}
    </label>
    <div class="form-group">
        <select {{ $attributes }} name="{{ $name }}"
            class="form-select form-select-lg form-select-solid" id="{{ $name }}_select"
            aria-label="{{ $placeholder }}" value={{ $value }} {{ $required == true ? 'required' : '' }}>
            @if (isset($placeholder))
                <option selected>{{ $placeholder }}</option>
            @endif

            @foreach ($options as $key => $item)
                @if ($selected && $selected == $key)
                    <option value="{{ $key }}" selected>{{ $item }}</option>
                @else
                    <option value="{{ $key }}">{{ $item }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<!--end::Input group-->