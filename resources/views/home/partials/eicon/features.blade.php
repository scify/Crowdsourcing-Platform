<div class="row">
    <div class="col-md-12">
        <h2>Features</h2>
        <div class="content-container">
            <div class="text-center">
                <ul id="features-nav" class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="#citizens" aria-controls="citizens" role="tab"
                                                              data-widget="tab">BUILT FOR YOU</a></li>
                    <li role="presentation"><a href="#managers" aria-controls="managers" role="tab"
                                               data-widget="tab">MAKE A DIFFERENCE</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="citizens">

                    <div class="features-wrapper">
                        <div class="features-list">
                            <div class="feature img-left">
                                <img src="{{asset('images/landing-page/features/participate.jpg')}}" alt="participate">
                                <p class="large-screens small-screens">Join our crowdsourcing platform in order to <b>make your voice heard!</b>
                                    You can enrich the reports by speaking up and providing your own input.</p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens small-screens"><b>Keep track</b> of your responses and stay informed about all the planned reports.</p>
                                <img src="{{asset('images/landing-page/features/keep-track.jpg')}}" alt="keep track">
                            </div>
                            <div class="feature img-left">
                                <img src="{{asset('images/landing-page/features/invite.jpg')}}" alt="invite">
                                <p class="large-screens"><b>Invite your friends and colleagues</b> to contribute to reports that
                                    actually matter.</p>
                                <p class="small-screens"><b>Invite your friends and colleagues</b> to contribute to reports that
                                    actually matter.</p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens small-screens"><b>Win awards</b> as a "thank you" for your
                                    impact in the reports.</p>
                                <img src="{{asset('images/landing-page/features/celebrating.jpg')}}" alt="celebrating">
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="managers">
                    <div class="features-wrapper">
                        <div class="features-list">
                            <div class="feature img-left">
                                <img src="{{asset('images/landing-page/features/create-projects.jpg')}}"
                                     alt="create crowdsourcing projects">
                                <p class="large-screens small-screens"><b>Let others learn</b> from your expertise
                                </p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens"><b>Check the impact</b> of your contribution, after the
                                    <b>experts'</b> opinions transform into a publicly available report.</p>
                                <img src="{{asset('images/landing-page/features/impact.jpg')}}" alt="impact">
                                <p class="small-screens"><b>Check the impact</b> of your contribution, after the
                                    citizens opinions transform into a publicly available report.</p>
                            </div>
                            <div class="feature img-left">
                                <img src="{{asset('images/landing-page/features/integrate.jpg')}}" alt="integrate">
                                <p class="large-screens small-screens"><b>Learn and get new insights</b> by joining the discussion.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--@push('scripts')--}}
{{--<script src="{{mix('dist/js/landingPageController.js')}}?{{env("APP_VERSION")}}"></script>--}}
{{--@endpush--}}
