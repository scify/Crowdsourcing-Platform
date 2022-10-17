@php
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\File;
    $currentLocale = app()->getLocale();
    $langPath = base_path('lang/' . $currentLocale);
    $translations = Cache::rememberForever('translations_' . $currentLocale, function () use ($langPath) {
        return collect(File::allFiles($langPath))->flatMap(function ($file) {
            return [
                $translation = $file->getBasename('.php') => trans($translation),
            ];
        })->toJson();
    });
@endphp

<script>
    window.Laravel = {!! json_encode([
                'baseUrl' => url("/"),
                'locale' => app()->getLocale(),
                'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; }),
                'translations' => json_decode($translations)
            ]) !!};
</script>
<script type="module" src="{{ mix('dist/js/manifest.js') }}"></script> {{-- The Webpack manifest runtime--}}
<script type="module" src="{{ mix('dist/js/vendor.js') }}"></script> {{-- Vendor libraries like jQuery, bootstrap --}}
<script src="{{ mix('dist/js/common.js')}}"></script> {{-- our application common code --}}
@if (isset($includeBackofficeCommonJs) && $includeBackofficeCommonJs)
    <script src="{{ mix('dist/js/common-backoffice.js')}}"></script> {{-- backend common code --}}
@endif
@if(config('app.user_way_id'))
    <script>(function () {
            const s = document.createElement("script");
            s.setAttribute("data-account", '{{ config('app.user_way_id') }}');
            s.setAttribute("src", "https://cdn.userway.org/widget.js");
            document.body.appendChild(s);
        })();</script>
    <noscript>Enable JavaScript to ensure <a href="https://userway.org">website accessibility</a></noscript>
@endif
@stack('scripts')
