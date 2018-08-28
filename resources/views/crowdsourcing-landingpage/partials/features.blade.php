<div class="row">
    <div class="col-md-12">
        <h2>About Us</h2>
        <div class="content-container">
            <p>Who we are: The European Citizen Action Service (ECAS) is an international,
                Brussels-based non-profit organisation with a pan-European membership and 27 years of experience in empowering citizens.
                ECAS believes in an inclusive, transparent, citizen-centric and democratic European Union in which citizens’
                rights are at the heart of decision making at all levels and in which citizens are informed, consulted and can actively participate.
                <br> <br>
                Our Crowdsourcing: Crowdsourcing is a way of solving problems and producing new ideas by connecting online with
                people that you otherwise wouldn’t reach, giving citizens’ the opportunity to learn from others, collaborate
                and participate in the decision-making.
            </p>
            <br><br>
            <p class="text-center margin-bottom">With our ECAS crowdsourcing platform we aim at:</p>
            <div class="featuresListContainer">
                <ul class="featuresList">
                    <li>
                        <p>encouraging citizens to speak up on issues directly affecting them</p>
                    </li>
                    <li>
                        <p>increasing citizens' democratic participation in political life</p>
                    </li>
                    <li>
                        <p>stimulating citizens' engagement with the EU</p>
                    </li>
                    <li>
                        <p>improving citizens‘ understanding of EU policy-making processes</p>
                    </li>
                </ul>
            </div>
            <div class="text-center">
                <ul id="features-nav" class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="#citizens" aria-controls="citizens" role="tab"
                                                              data-toggle="tab">BUILT FOR CITIZENS</a></li>
                    <li role="presentation"><a href="#managers" aria-controls="managers" role="tab"
                                               data-toggle="tab">OPEN-SOURCE PLATFORM</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="citizens">

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
                                    citizens' opinions transform into a publicly available report.</p>
                                <img src="{{asset('images/landing-page/features/impact.jpg')}}" alt="impact">
                                <p class="small-screens"><b>Check the impact</b> of your contribution, after the
                                    citizens' opinions transform into a publicly available report.</p>
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