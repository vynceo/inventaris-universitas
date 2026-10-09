<div {{ $attributes->merge(['class' => 'card']) }}>
    @if(isset($header))
        <div class="card-header">
            <div class="flex items-center gap-3">
                @if(isset($icon))
                    <div class="icon-box" style="background: {{ $iconBg ?? '#eef2ff' }}; color: {{ $iconColor ?? '#4f46e5' }};">
                        <i class="{{ $icon }}"></i>
                    </div>
                @endif
                <span style="font-weight: 600; color: #1a1a2e;">{{ $header }}</span>
            </div>
            @if(isset($action))
                <div>{!! $action !!}</div>
            @endif
        </div>
    @endif

    <div class="card-body {{ $bodyClass ?? '' }}">
        {{ $slot }}
    </div>
</div>
