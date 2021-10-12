<?php

return array(
    'dsn' => config('app.sentry_dsn'),

    // capture release as git sha
    // 'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),

    // Capture bindings on SQL queries
    'breadcrumbs.sql_bindings' => true,

    'release' => config("app.version")
);
