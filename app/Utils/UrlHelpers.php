<?php

use Illuminate\Support\Facades\Request;

/**
 * Used on menu to identify that a given menu item is selected
 *
 * @param  string  $urlPatternToMatch the menu item url
 * @return string A relevant CSS class
 */
function UrlMatchesMenuItem(string $urlPatternToMatch): string {
    return Request::is($urlPatternToMatch) ? 'active' : '';
}

function getNameOfRoute($currentRoute) {
    if ($currentRoute == null || $currentRoute->getName() == null) {
        return 'home';
    }

    return $currentRoute->getName();
}

function SetParameterAndGetAll($currentRoute, $parameter, $key) {
    if ($currentRoute == null || $currentRoute->getName() == null) {
        return [];
    }

    $currentRoute->setParameter($parameter, $key);

    return $currentRoute->parameters();
}

function getRouteParameters() {
    $fullUrl = Request::fullUrl();
    if (! strpos($fullUrl, '?')) {
        return '';
    }

    return substr($fullUrl, strpos($fullUrl, '?'));
}
