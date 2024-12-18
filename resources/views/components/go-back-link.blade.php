<div {{ $attributes->merge(['class' => 'go-back-link']) }}>
    <a href="{{ $attributes['href'] }}">
        <i class="fas fa-caret-left"></i>
        <span class="ml-2">{{ $slot }}</span>
    </a>
</div>
