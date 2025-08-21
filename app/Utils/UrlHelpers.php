<?php

declare(strict_types=1);

/**
 * Used on menu to identify that a given menu item is selected
 *
 * @param  string  $routeName  the route name to compare with the current route
 *
 * @return string A relevant CSS class
 */
function UrlMatchesMenuItem(string $routeName): string {
    return Route::currentRouteName() === $routeName ? 'active' : '';
}

function getNameOfRoute($currentRoute) {
    if ($currentRoute == null || $currentRoute->getName() == null) {
        return 'home';
    }

    return $currentRoute->getName();
}
