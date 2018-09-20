<script src="{{ mix('dist/js/manifest.js') }}?{{ env("APP_VERSION") }}"></script> {{-- The Webpack manifest runtime--}}
<script src="{{ mix('dist/js/vendor.js') }}?{{env("APP_VERSION")}}"></script> {{-- Vendor libraries like jQuery, bootstrap --}}
<script src="{{ mix('dist/js/common.js')}}?{{env("APP_VERSION")}}"></script> {{-- our application common code --}}
@if (App::environment('production'))
    @include('analytics')
@endif
@stack('scripts')
