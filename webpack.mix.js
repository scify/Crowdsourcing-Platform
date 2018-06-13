var mix = require('laravel-mix');

mix.disableNotifications();

mix.js('resources/assets/js/common.js', 'public/dist/js/')
    .js('resources/assets/js/pages/register.js', 'public/dist/js')
    .js('resources/assets/js/pages/articleController.js', 'public/dist/js')
    .js('resources/assets/js/pages/articlesListController.js', 'public/dist/js')
    .js('resources/assets/js/pages/myProfile.js', 'public/dist/js')
    .js('resources/assets/js/partials/collaborationRespondToRequest.js', 'public/dist/js')
    .js('resources/assets/js/partials/cmsListController.js', 'public/dist/js')
    .js('resources/assets/js/partials/collaborationModalHeader.js', 'public/dist/js')
    .js('resources/assets/js/partials/collaborationViewRequestResponse.js', 'public/dist/js')
    .js('resources/assets/js/pages/onlineStore.js', 'public/dist/js')
    .js('resources/assets/js/pages/paymentsController.js', 'public/dist/js')
    .js('resources/assets/js/pages/manageCategories.js', 'public/dist/js')
    .sass('resources/assets/sass/common.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/blog-roll.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/register.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/article-create-edit.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/articles-list.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/online-store.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/manage-payments.scss', 'public/dist/css')
    .sass('resources/assets/sass/partials/cms-list.scss', 'public/dist/css')
    .sass('resources/assets/sass/partials/collaboration_status.scss', 'public/dist/css')
    .sass('resources/assets/sass/pages/my-profile.scss', 'public/dist/css')
    .sass('resources/assets/sass/partials/collaboration-modal-header.scss', 'public/dist/css')
    .sass('resources/assets/sass/partials/collaboration-request-response.scss', 'public/dist/css')
    .sass('resources/assets/sass/cmsProductionWebSite/main.scss', 'public/dist/css/production')

    .extract([
        'jquery-slimscroll', 'fastclick', 'admin-lte', 'bootstrap-sweetalert', 'select2' , 'bootstrap', 'jquery-toast-plugin'
    ])

    .sourceMaps()
    .version();

// move sweetalert.css to public/dist/css
mix.copy(['node_modules/bootstrap-sweetalert/dist/sweetalert.css'], 'public/dist/css/sweetalert.css');