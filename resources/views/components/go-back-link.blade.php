<div {{ $attributes->merge(['class' => 'go-back-link']) }}>
    <a href="{{ $attributes['href'] }}">
        <i class="fas fa-caret-left"></i>
        <span class="ms-2">{{ $slot }}</span>
    </a>
</div>
