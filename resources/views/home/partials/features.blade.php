<div class="row">
    <div class="col-md-12">
        <h2 class="mb-5">Features</h2>
        <div class="content-container">
            <ul id="features-nav" class="nav nav-pills justify-content-center mb-5" role="tablist">
                <li role="presentation" class="nav-item"><a class="nav-link active" href="#citizens"
                                                            aria-controls="citizens" role="tab"
                                                            data-toggle="tab">
                        {{ __('common.built_for_citizens') }}
                    </a></li>
                <li role="presentation" class="nav-item"><a class="nav-link" href="#platform" aria-controls="platform"
                                                            role="tab"
                                                            data-toggle="tab">
                        {{ __('common.open_source_platform') }}
                    </a></li>
            </ul>
            <div class="tab-content py-5">
                <div role="tabpanel" class="tab-pane fade show active" id="citizens">

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
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="platform">
                    <div class="features-wrapper">
                        <div class="features-list">
                            <div class="feature img-left">
                                <img loading="lazy" src="{{asset('images/landing-page/features/create-projects.webp')}}"
                                     alt="create crowd-sourcing campaigns">
                                <p class="large-screens small-screens">
                                    {!! __('common.features_platform_1') !!}
                                </p>
                            </div>
                            <div class="feature img-right">
                                <p class="large-screens">
                                    {!! __('common.features_platform_2') !!}
                                </p>
                                <img loading="lazy" src="{{asset('images/landing-page/features/questionnaire.webp')}}"
                                     alt="manage your questionnaires">
                                <p class="small-screens">
                                    {!! __('common.features_platform_3') !!}
                                </p>
                            </div>
                            <div class="feature img-left">
                                <img loading="lazy" src="{{asset('images/landing-page/features/integrate.webp')}}"
                                     alt="integrate">
                                <p class="large-screens small-screens">
                                    {!! __('common.features_platform_4') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
