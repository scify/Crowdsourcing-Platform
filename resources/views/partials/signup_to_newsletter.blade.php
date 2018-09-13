<div class="row" id="newsletter">
    <div class="col-md-12 no-padding">
        <h2>Newsletter</h2>
        <div class="content-container">
            <p class="text-center">Learn about all our new projects, get updates on active ones and contribute where
                it is most
                needed!</p>
            <div class="sign-up row">
                <div class="col-md-3" style="float: none; margin: 0 auto;">
                        <a href="https://ecas.org/#mc_signup" target="_blank" class="btn btn-block btn-primary signup-btn">Sign up!</a>
                </div>
            </div>
            {{--<div class="sign-up row" data-url="{{route('newsletter')}}">--}}
                {{--<div class="col-md-2 col-md-offset-3 col-xs-10 col-xs-offset-1">--}}
                    {{--<input type="text" class="form-control" name="first_name" placeholder="First Name" required>--}}
                {{--</div>--}}
                {{--<div class="col-md-2 col-xs-10 col-xs-offset-1">--}}
                    {{--<input type="email" class="form-control" name="email" placeholder="Email" required>--}}
                {{--</div>--}}
                {{--<div class="col-md-2 col-xs-10 col-xs-offset-1">--}}
                    {{--<a class="btn btn-block btn-primary signup-btn">Sign up!</a>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-6 col-md-offset-3 text-center">--}}
                    {{--<div class="newsletter-msg">--}}
                        {{--<div class="subscription-success-msg">--}}
                            {{--<span class="fa fa-check-circle"></span> <span class="msg">You have been subscribed to our newsletter. Thank you!</span>--}}
                        {{--</div>--}}
                        {{--<div class="subscription-error-msg">--}}
                            {{--<span class="fa fa-times-circle"></span> <span class="msg">An error occurred. Please try again later.</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{asset('dist/js/newsletter-signup.js')}}"></script>
@endpush