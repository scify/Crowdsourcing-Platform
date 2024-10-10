<div class="socialSignInContainer">
    <div class="row mb-sm-2 mb-md-0">
        <div class="col-sm-5 title">
            {{ __("login-register.login_with") }}
        </div>
        <div class="col-sm-7 align-left">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2 p-0 text-center offset-md-4 offset-sm-0">
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
                    <div class="col-2 px-0 text-center">
                        <a class="socialSignIn linkedin" href="{{url('login/social/linkedin-openid')}}"><i
                                    class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
