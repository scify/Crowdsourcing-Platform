<div class="socialSignInContainer">
    <div class="row">
        <div class="col-sm-4 title">
            {{ __("login-register.login_with") }}
        </div>
        <div class="col-sm-8 align-left">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2 p-0 text-center offset-2">
                        <a class="socialSignIn" href="{{url('login/social/facebook')}}"><i
                                    class="fab fa-facebook-square"></i></a>
                    </div>
                    <div class="col-2 p-0 text-center me-1">
                        <a class="socialSignIn" href="{{url('login/social/twitter')}}"><i
                                    class="fab fa-twitter-square"></i></a>

                    </div>
                    <div class="col-2 whole px-0 text-center me-1">
                        <a class="socialSignIn google" href="{{url('login/social/google')}}"><i
                                    class="fab fa-google"></i></a>
                    </div>
{{--                    <div class="col-2 whole px-0 text-center">--}}
{{--                        <a class="socialSignIn microsoft" href="{{url('login/social/microsoft')}}"><i--}}
{{--                                    class="fab fa-windows"></i></a>--}}
{{--                    </div>--}}
                    <div class="col-2 px-0 text-center">
                        <a class="socialSignIn linkedin" href="{{url('login/social/linkedin')}}"><i
                                    class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
