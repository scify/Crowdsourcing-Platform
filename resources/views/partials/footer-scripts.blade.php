@php
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\File;
    $currentLocale = app()->getLocale();
    if(!File::exists(base_path('resources/lang/' . $currentLocale)))
        $currentLocale = "en";
    $langPath = base_path('resources/lang/' . $currentLocale);
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
@vite('resources/assets/js/common.js') {{-- our application common code --}}
@if (isset($includeBackofficeCommonJs) && $includeBackofficeCommonJs)
    @vite('resources/assets/js/common-backoffice.js') {{-- backend common code --}}
@endif
@if(config('app.user_way_id'))
    <script defer async>(function () {
            const s = document.createElement("script");
            s.setAttribute("data-account", '{{ config('app.user_way_id') }}');
            s.setAttribute("src", "https://cdn.userway.org/widget.js");
            document.body.appendChild(s);
        })();</script>
    <noscript>Enable JavaScript to ensure <a href="https://userway.org">website accessibility</a></noscript>
@endif
@stack('scripts')
