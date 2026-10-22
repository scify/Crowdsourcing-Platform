<div class="socialSignInContainer">
    <div class="row mb-sm-2 mb-md-0">
        <div class="col-sm-5 title">
            {{ __("login-register.login_with") }}
        </div>
        <div class="col-sm-7 align-left">
            {{-- One flex row: col-2 cells with extra margins overflowed the BS5
                 grid and wrapped the last icon to a second line --}}
            <div class="d-flex justify-content-md-center gap-1">
                <a class="socialSignIn" href="{{url('login/social/facebook')}}"><i
                            class="fab fa-facebook-square"></i></a>
                <a class="socialSignIn" href="{{url('login/social/twitter')}}"><i
                            class="fab fa-twitter-square"></i></a>
                <a class="socialSignIn google" href="{{url('login/social/google')}}"><i
                            class="fab fa-google"></i></a>
                <a class="socialSignIn linkedin" href="{{url('login/social/linkedin-openid')}}"><i
                            class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </div>
</div>
