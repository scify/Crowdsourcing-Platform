<div {{ $attributes->merge(['class' => 'go-back-link']) }}>
    <a href="{{ $attributes['href'] }}">
        <i class="fas fa-caret-left"></i>
        <span>{{ $slot }}</span>
    </a>
</div>
