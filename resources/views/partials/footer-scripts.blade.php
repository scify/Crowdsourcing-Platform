<script async src="{{ mix('dist/js/manifest.js') }}"></script> {{-- The Webpack manifest runtime--}}
<script async src="{{ mix('dist/js/vendor.js') }}"></script> {{-- Vendor libraries like jQuery, bootstrap --}}
<script async src="{{ mix('dist/js/common.js')}}"></script> {{-- our application common code --}}
@stack('scripts')
