<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

trait RedirectsToSafeUrl {
    /**
     * Returns the URL when it is a local path or an absolute URL on the application host.
     * Otherwise returns the default post-login URL, so "redirectTo" cannot send users to another site.
     */
    protected function safeRedirectUrl(mixed $url): string {
        if (! is_string($url) || $url === '' || str_contains($url, '\\')) {
            return $this->redirectTo();
        }

        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return $url;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        $host = parse_url($url, PHP_URL_HOST);
        $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);

        return in_array($scheme, ['http', 'https'], true) && is_string($host) && strcasecmp($host, (string) $appHost) === 0
            ? $url
            : $this->redirectTo();
    }
}
