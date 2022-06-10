<!-- Google Analytics -->
@if(config('app.google_analytics_id'))
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', '{{ config('app.google_analytics_id') }}', 'auto');
        ga('set', 'anonymizeIp', true);
        ga('send', 'pageview');

    </script>
@endif
<!-- End Google Analytics -->
<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push(
            {'gtm.start': new Date().getTime(), event: 'gtm.js'}
        );
        const f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l !== 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', '{{ config('app.google_tag_manager_id') }}');</script>
<!-- End Google Tag Manager -->
