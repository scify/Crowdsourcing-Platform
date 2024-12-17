<div class="container-fluid h-100 w-100 px-0">
    <div class="row h-100 w-100 align-items-center mx-0"
         style="background-image: url({{asset('images/active_participation.webp')}});">
        <div class="overlay-filter" style="top: @if (App::environment('staging')) 128.75px @else 93.75px @endif"></div>
        <div class="col-lg-6 col-md-10 col-sm-11 mx-auto motto-content h-75">
            <div class="frosted"></div>
            <div id="project-motto" class="h-100">
                <div class="container h-100">
                    <div class="row title-row h-50">
                        <div class="col px-5">
                            <h1 class="mb-5">{{ __('common.home_motto') }}</h1>
                            <h2 class="mb-0">{{ __('common.home_sub_motto') }}</h2>
                        </div>
                    </div>
                    <div class="row h-50">
                        <div class="col-lg-6 col-md-10 col-sm-12 mx-auto">
                            <div class="w-100 mx-auto btn-container">
                                <a href="#projects" class="btn btn-block btn-primary call-to-action smooth-goto">
                                    {{ __('common.home_call_to_action') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
