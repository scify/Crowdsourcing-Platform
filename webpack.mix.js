const mix = require('laravel-mix');

mix.disableSuccessNotifications();

mix.js('resources/assets/js/common.js', 'public/dist/js/')
    .js('resources/assets/js/pages/register.js', 'public/dist/js')
    .js('resources/assets/js/pages/myProfile.js', 'public/dist/js')
    .js('resources/assets/js/pages/manageQuestionnaires.js', 'public/dist/js')
    .js('resources/assets/js/pages/landingPage.js', 'public/dist/js')
    .js('resources/assets/js/pages/home.js', 'public/dist/js')
    .js('resources/assets/js/projectGoal.js', 'public/dist/js')
    .js('resources/assets/js/pages/manageProject.js', 'public/dist/js')
    .js('resources/assets/js/pages/myQuestionnaireResponses.js', 'public/dist/js')
    .js('resources/assets/js/pages/questionnaire/reports.js', 'public/dist/js')
    .js('resources/assets/js/pages/questionnaire/statistics.js', 'public/dist/js')
    .js('resources/assets/js/questionnaireSocialShare.js', 'public/dist/js')
    .js('resources/assets/js/partials/newsletter-signup.js', 'public/dist/js')
    .js('resources/assets/js/UsersListController.js', 'public/dist/js')
    .extract([
        'jquery', 'jquery-slimscroll', 'fastclick', 'admin-lte', 'bootstrap-sweetalert',
        'select2', 'bootstrap', 'jquery-toast-plugin', 'bootstrap-tagsinput',
        'bootstrap-colorpicker', 'survey-jquery', 'survey-knockout', 'survey-creator'
    ])
    .sourceMaps()
    .webpackConfig({
        devtool: 'source-map',
        resolve: {fallback: {fs: false, path: false}}
    })
    .version()
    .vue();

mix.autoload({
    'jquery': ['$', 'window.jQuery', 'jQuery']
});


mix.sass('resources/assets/sass/common.scss', 'public/dist/css')
    .sass('resources/assets/sass/gamification/badges.scss', 'public/dist/css')
    .sass('resources/assets/sass/gamification/badge-single.scss', 'public/dist/css')
    .sass('resources/assets/sass/gamification/next-step.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/social-share.scss', 'public/dist/css')
    .sass('resources/assets/sass/auth.scss', 'public/dist/css')
    .sass('resources/assets/sass/errors.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/reports.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/statistics.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/my-dashboard.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/my-questionnaire-responses.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/projects-list.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/landing-page.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/create-edit-project.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/create-questionnaire.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/manage-questionnaires.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/home.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/all-projects.scss', 'public/dist/css')
    .sourceMaps()
    .webpackConfig({
        devtool: 'source-map',
        resolve: {fallback: {fs: false, path: false}}
    })
    .version();
