<div class="container-fluid h-100 w-100 px-0">
    <div class="row h-100 w-100 align-items-center mx-0"
         style="background-image: url({{asset('images/active_participation.webp')}});">
        <div class="overlay-filter"
             style="top: @if (App::environment('staging')) 128.75px @else 93.75px @endif"></div>
        <div class="col-lg-5 col-md-10 col-sm-11 mx-auto motto-content px-0">
            <div class="frosted"></div>
            <div id="project-motto">
                <h1>Let's crowdsource!<br>Taking decisions with citizens and not for them</h1>
                <div class="w-50 mx-auto">
                    <a href="{{route('login')}}" class="btn btn-block call-to-action">Share your ideas</a>
                </div>
            </div>
        </div>
    </div>
</div>
