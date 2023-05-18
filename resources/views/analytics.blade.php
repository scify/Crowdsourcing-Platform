@if(isset($_COOKIE[config('cookies_consent.cookie_prefix')
. 'cookies_consent_targeting']))
    <!-- Google Analytics -->
    @if(config('app.google_analytics_id'))
        <!-- Google tag (gtag.js) -->
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ config('app.google_analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', '{{ config('app.google_analytics_id') }}', {'anonymize_ip': true});
        </script>
    @endif
    <!-- End Google Analytics -->
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l !== 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{ config('app.google_tag_manager_id') }}');</script>
    <!-- End Google Tag Manager -->
@endif