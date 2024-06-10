const mix = require('laravel-mix');
const path = require("path");
const webpack = require("webpack");
const ESLintPlugin = require('eslint-webpack-plugin');

mix.disableNotifications();

mix.webpackConfig({
    plugins: [new ESLintPlugin({
        fix: true,
        extensions: ['js', 'vue'],
    })],
});

mix.js('resources/assets/js/common-backoffice.js', 'public/dist/js/')
    .js('resources/assets/js/common.js', 'public/dist/js/')
    .js('resources/assets/js/pages/register.js', 'public/dist/js')
    .js('resources/assets/js/questionnaire/manage-questionnaires.js', 'public/dist/js')
    .js('resources/assets/js/project/landing-page.js', 'public/dist/js')
    .js('resources/assets/js/project/manage-project.js', 'public/dist/js')
    .js('resources/assets/js/questionnaire/my-questionnaire-responses.js', 'public/dist/js')
    .js('resources/assets/js/questionnaire/questionnaire-reports.js', 'public/dist/js')
    .js('resources/assets/js/questionnaire/questionnaire-statistics.js', 'public/dist/js')
    .js('resources/assets/js/questionnaire/questionnaire-social-share.js', 'public/dist/js')
    .js('resources/assets/js/partials/newsletter-signup.js', 'public/dist/js')
    .js('resources/assets/js/pages/manage-users.js', 'public/dist/js')
    .js('resources/assets/js/questionnaire/questionnaire-thanks.js', 'public/dist/js')
    .js('resources/assets/js/questionnaire/questionnaire-create-edit.js', 'public/dist/js')
    .js('resources/assets/js/questionnaire/questionnaire-feedback.js', 'public/dist/js')
    .js('resources/assets/js/questionnaire/questionnaire-statistics-colors.js', 'public/dist/js')
    .sourceMaps()
    .webpackConfig({
        devtool: 'source-map',
        resolve: {
            alias: {jQuery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.js')},
            fallback: {
                fs: false,
                path: false,
                "stream": false,
                "constants": false,
                "crypto": false
            }
        },
        plugins: [
            // ProvidePlugin helps to recognize $ and jQuery words in code
            // And replace it with require('jquery')
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery'
            })
        ],
        stats: {
            children: true,
        },
    })
    .version()
    .vue();

mix.autoload({
    'jquery': ['$', 'window.jQuery', 'jQuery']
});


mix.sass('resources/assets/sass/common.scss', 'public/dist/css')
    .sass('resources/assets/sass/common-backoffice.scss', 'public/dist/css')
    .sass('resources/assets/sass/gamification/badges.scss', 'public/dist/css')
    .sass('resources/assets/sass/gamification/badge-single.scss', 'public/dist/css')
    .sass('resources/assets/sass/gamification/next-step.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/social-share.scss', 'public/dist/css')
    .sass('resources/assets/sass/auth.scss', 'public/dist/css')
    .sass('resources/assets/sass/errors.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/reports.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/statistics.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/my-dashboard.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/my-questionnaire-responses.scss', 'public/dist/css')
    .sass('resources/assets/sass/project/projects-list.scss', 'public/dist/css')
    .sass('resources/assets/sass/project/landing-page.scss', 'public/dist/css')
    .sass('resources/assets/sass/project/create-edit-project.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/create-questionnaire.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/manage-questionnaires.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/home.scss', 'public/dist/css')
    .sass('resources/assets/sass/project/all-projects.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/questionnaire-thanks.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/questionnaire-statistics-colors.scss', 'public/dist/css')

    .sourceMaps()
    .webpackConfig({
        devtool: 'source-map',
        resolve: {fallback: {fs: false, path: false}},
        stats: {
            children: true,
        },
    })
    .version();
