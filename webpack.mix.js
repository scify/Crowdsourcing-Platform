var mix = require('laravel-mix');

mix.disableNotifications();

mix.js('resources/assets/js/common.js', 'public/dist/js/')
    .js('resources/assets/js/pages/register.js', 'public/dist/js')
    .js('resources/assets/js/pages/myProfile.js', 'public/dist/js')
    .js('resources/assets/js/pages/createQuestionnaire.js', 'public/dist/js')
    .js('resources/assets/js/pages/manageQuestionnaires.js', 'public/dist/js')
    .js('resources/assets/js/pages/landingPage.js', 'public/dist/js')
    .js('resources/assets/js/pages/home.js', 'public/dist/js')
    .js('resources/assets/js/projectGoal.js', 'public/dist/js')
    .js('resources/assets/js/pages/translateQuestionnaire.js', 'public/dist/js')
    .js('resources/assets/js/questionnaireSocialShare.js', 'public/dist/js')
    .js('resources/assets/js/partials/newsletter-signup.js', 'public/dist/js')
    .js('resources/assets/js/UsersListController.js', 'public/dist/js')
    .sass('resources/assets/sass/common.scss', 'public/dist/css')
    .sass('resources/assets/sass/gamification/badges.scss', 'public/dist/css')
    .sass('resources/assets/sass/gamification/badge-single.scss', 'public/dist/css')
    .sass('resources/assets/sass/gamification/next-step.scss', 'public/dist/css')
    .sass('resources/assets/sass/questionnaire/social-share.scss', 'public/dist/css')
    .sass('resources/assets/sass/auth.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/my-dashboard.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/projects-list.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/landing-page.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/edit-project.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/create-questionnaire.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/manage-questionnaires.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/translate-questionnaire.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/home.scss', 'public/dist/css')
    .extract([
        'jquery-slimscroll', 'fastclick', 'admin-lte', 'bootstrap-sweetalert', 'select2', 'bootstrap', 'jquery-toast-plugin'
    ])
    .sourceMaps()
    .version();

// move sweetalert.css to public/dist/css
// mix.copy(['node_modules/bootstrap-sweetalert/dist/sweetalert.css'], 'public/dist/css/sweetalert.css');

// move select2.min.css to public/dist/css
mix.copy(['node_modules/select2/dist/css/select2.min.css'], 'public/dist/css/select2.min.css');
// move surveyjs files to public/dist/css
mix.copy(['resources/assets/plugins/surveyjs-1.0.30/*'], 'public/dist/css/');