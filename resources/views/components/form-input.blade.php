<div {{ $attributes->merge(['class' => 'form-group']) }}>
    @if(isset($label))
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required)
                <span style="color: #dc2626;">*</span>
            @endif
        </label>
    @endif

    <div class="input-group">
        @if(isset($icon))
            <span class="icon"><i class="{{ $icon }}"></i></span>
        @endif

        @if(($type ?? 'text') === 'textarea')
            <textarea name="{{ $name }}" id="{{ $name }}"
                placeholder="{{ $placeholder ?? '' }}"
                class="form-control"
                rows="{{ $rows ?? 4 }}"
                {{ $required ? 'required' : '' }}>{{ old($name, $value ?? '') }}</textarea>
        @elseif(($type ?? 'text') === 'select')
            <select name="{{ $name }}" id="{{ $name }}" class="form-control" {{ $required ? 'required' : '' }}>
                {{ $slot }}
            </select>
        @else
            <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}"
                value="{{ old($name, $value ?? '') }}"
                placeholder="{{ $placeholder ?? '' }}"
                class="form-control"
                {{ $required ? 'required' : '' }}>
        @endif
    </div>

    @error($name)
        <p style="font-size: 12px; color: #dc2626; margin-top: 4px;">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
        </p>
    @enderror
</div>
