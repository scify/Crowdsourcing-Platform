
{{-- todo: load jquery also via webpack vendor.js. --}}
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>

<script src="{{ mix('dist/js/manifest.js') }}?{{ env("APP_VERSION") }}"></script> {{-- The Webpack manifest runtime--}}
<script src="{{ mix('dist/js/vendor.js') }}?{{env("APP_VERSION")}}"></script> {{-- Vendor libraries like jQuery, bootstrap --}}
{{--Loading summernote and select2 JS via CDN because webpack does not seem to get it working...--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ mix('dist/js/common.js')}}?{{env("APP_VERSION")}}"></script> {{-- our application common code --}}

@stack('scripts')
