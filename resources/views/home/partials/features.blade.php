<div class="row">
    <div class="col-md-12">
        <h2 class="mb-5">Features</h2>
        <div class="content-container">
            <ul id="features-nav" class="nav nav-pills justify-content-center mb-5" role="tablist">
                <li role="presentation" class="nav-item"><a class="nav-link active" href="#administrators"
                                                            aria-controls="administrators" role="tab"
                                                            data-toggle="tab">
                        {{ __('common.for_organisations') }}
                    </a></li>
                <li role="presentation" class="nav-item"><a class="nav-link" href="#citizens"
                                                            aria-controls="citizens" role="tab"
                                                            data-toggle="tab">
                        {{ __('common.built_for_citizens') }}
                    </a></li>
            </ul>
            <div class="tab-content py-5">
                <div role="tabpanel" class="tab-pane fade show active" id="administrators">
                    <div class="features-wrapper">
                        <div class="features-list">
                            <div class="feature img-left">
                                <img loading="lazy"
                                     src="{{ asset('images/landing-page/features/admin-campaigns.webp') }}"
                                     alt="create and manage campaigns"
                                     class="img-placeholder">
                                <p class="large-screens small-screens">
                                    {!! __('common.features_organisations_1') !!}
                                </p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens">
                                    {!! __('common.features_organisations_2') !!}
                                </p>
                                <img loading="lazy"
                                     src="{{ asset('images/landing-page/features/admin-problems-solutions.webp') }}"
                                     alt="manage problems and solutions"
                                     class="img-placeholder">
                                <p class="small-screens">
                                    {!! __('common.features_organisations_2') !!}
                                </p>
                            </div>
                            <div class="feature img-left">
                                <img loading="lazy"
                                     src="{{ asset('images/landing-page/features/admin-multilingual.webp') }}"
                                     alt="multilingual content"
                                     class="img-placeholder">
                                <p class="large-screens small-screens">
                                    {!! __('common.features_organisations_3') !!}
                                </p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens">
                                    {!! __('common.features_organisations_4') !!}
                                </p>
                                <img loading="lazy"
                                     src="{{ asset('images/landing-page/features/admin-statistics.webp') }}"
                                     alt="statistics and reports"
                                     class="img-placeholder">
                                <p class="small-screens">
                                    {!! __('common.features_organisations_4') !!}
                                </p>
                            </div>
                            <div class="feature img-left">
                                <img loading="lazy"
                                     src="{{ asset('images/landing-page/features/admin-moderation.webp') }}"
                                     alt="moderation"
                                     class="img-placeholder">
                                <p class="large-screens small-screens">
                                    {!! __('common.features_organisations_5') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="citizens">

                    <div class="features-wrapper">
                        <div class="features-list">
                            <div class="feature img-left">
                                <img loading="lazy" src="{{asset('images/landing-page/features/participate.webp')}}"
                                     alt="participate">
                                <p class="large-screens small-screens">
                                    {!! __('common.features_citizens_1') !!}
                                </p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens">
                                    {!! __('common.features_citizens_2') !!}
                                </p>
                                <img loading="lazy" src="{{asset('images/landing-page/features/impact.webp')}}"
                                     alt="impact">
                                <p class="small-screens">
                                    {!! __('common.features_citizens_3') !!}
                                </p>
                            </div>
                            <div class="feature img-left">
                                <img loading="lazy" src="{{asset('images/landing-page/features/keep-track.webp')}}"
                                     alt="keep track">
                                <p class="large-screens small-screens">
                                    {!! __('common.features_citizens_4') !!}
                                </p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens">
                                    {!! __('common.features_citizens_5') !!}
                                </p>
                                <img loading="lazy" src="{{asset('images/landing-page/features/invite.webp')}}"
                                     alt="invite">
                                <p class="small-screens">
                                    {!! __('common.features_citizens_6') !!}
                                </p>
                            </div>
                            <div class="feature img-left">
                                <img loading="lazy" src="{{asset('images/landing-page/features/celebrating.webp')}}"
                                     alt="celebrating">
                                <p class="large-screens small-screens">
                                    {!! __('common.features_citizens_7') !!}
                                </p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens">
                                    {!! __('common.features_citizens_8') !!}
                                </p>
                                <img loading="lazy"
                                     src="{{ asset('images/landing-page/features/propose-solutions.webp') }}"
                                     alt="propose solutions"
                                     class="img-placeholder">
                                <p class="small-screens">
                                    {!! __('common.features_citizens_8') !!}
                                </p>
                            </div>
                            <div class="feature img-left">
                                <img loading="lazy"
                                     src="{{ asset('images/landing-page/features/vote-solutions.webp') }}"
                                     alt="vote for solutions"
                                     class="img-placeholder">
                                <p class="large-screens small-screens">
                                    {!! __('common.features_citizens_9') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
