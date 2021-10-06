<div class="row">
    <div class="col-md-12">
        <h2>Features</h2>
        <div class="content-container">
            <ul id="features-nav" class="nav nav-pills justify-content-center" role="tablist">
                <li role="presentation" class="nav-item"><a class="nav-link active" href="#citizens"
                                                            aria-controls="citizens" role="tab"
                                                            data-toggle="tab">BUILT FOR CITIZENS</a></li>
                <li role="presentation" class="nav-item"><a class="nav-link" href="#managers" aria-controls="managers"
                                                            role="tab"
                                                            data-toggle="tab">OPEN-SOURCE PLATFORM</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade show active" id="citizens">

                    <div class="features-wrapper">
                        <div class="features-list">
                            <div class="feature img-left">
                                <img src="{{asset('images/landing-page/features/participate.jpg')}}" alt="participate">
                                <p class="large-screens small-screens">Join our crowdsourcing platform in order to <b>make
                                        your voice heard</b>! You may contribute to our mission by speaking up and
                                    providing your own input.</p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens"><b>Check the impact</b> of your contribution, after the
                                    citizens opinions transform into a publicly available report.</p>
                                <img src="{{asset('images/landing-page/features/impact.jpg')}}" alt="impact">
                                <p class="small-screens"><b>Check the impact</b> of your contribution, after the
                                    citizens opinions transform into a publicly available report.</p>
                            </div>
                            <div class="feature img-left">
                                <img src="{{asset('images/landing-page/features/keep-track.jpg')}}" alt="keep track">
                                <p class="large-screens small-screens"><b>Keep track</b> of your responses and
                                    stay informed about other active projects.
                                </p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens"><b>Invite your friends</b> to contribute to projects that
                                    actually matter.</p>
                                <img src="{{asset('images/landing-page/features/invite.jpg')}}" alt="invite">
                                <p class="small-screens"><b>Invite your friends</b> to contribute to projects that
                                    actually matter.</p>
                            </div>
                            <div class="feature img-left">
                                <img src="{{asset('images/landing-page/features/celebrating.jpg')}}" alt="celebrating">
                                <p class="large-screens small-screens"><b>Win awards</b> as a "thank you" for your
                                    impact in our causes.</p>
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
                                <p class="large-screens small-screens"><b>Create new crowdsourcing projects</b> to
                                    motivate citizens to speak up!
                                </p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens"><b>Manage your questionnaires</b> effectively with our easy to
                                    use questionnaire editor.</p>
                                <img src="{{asset('images/landing-page/features/questionnaire.jpg')}}"
                                     alt="manage your questionnaires">
                                <p class="small-screens"><b>Manage your questionnaires</b> effectively with our easy to
                                    use questionnaire editor.</p>
                            </div>
                            <div class="feature img-left">
                                <img src="{{asset('images/landing-page/features/integrate.jpg')}}" alt="integrate">
                                <p class="large-screens small-screens"><b>Integrate with MailChimp</b> in just a click,
                                    to keep users always up to date with the latest projects and activities.</p>
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
