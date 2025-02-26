<div class="row" id="sitemap">
    <div class="col-lg-8 col-md-10 col-sm-11 mx-auto">
        <div class="container-fluid p-0">
            <div class="row pt-5">
                <div class="col-md-4 col-sm-12">
                    <div class="footer-grp">
                        <h3>ECAS Crowdsourcing Platform</h3>
                        <div class="mb-1">
                            <a href="https://ecas.org/about-ecas/" target="_blank">{{ __('common.about_us') }}</a>
                        </div>
                        <div class="mb-1">
                            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}#features">{{ __('common.features') }}</a>
                        </div>
                        <div class="mb-1">
                            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}#projects">{{ __('common.crowd_sourcing_campaigns') }}</a>
                        </div>
                        <div class="mb-1">
                            <a href="https://scify.org/en/" target="_blank">About SciFY</a>
                        </div>
                        <div class="mb-1">
                            <a href="{{ route('code-of-conduct') }}" target="_blank">Code of Conduct</a>
                        </div>
                        <div class="mb-1">
                            <a href="{{ route('terms.privacy' , ['locale' => app()->getLocale()]) }}" target="_blank">Platform
                                Privacy Policy</a>
                        </div>
                        <div class="mb-1">
                            <a href="javascript:void(0);" onclick="toggleCookieBanner()">Cookies Preferences</a>
                        </div>
                        <div class="mb-1"><a href="https://github.com/scify/Crowdsourcing-Platform" target="_blank">Github
                                ({{__('common.open_source_platform')}})</a></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="footer-grp">
                        <h3>{{ __('common.contact') }}</h3>
                        <div>
                            <b>{{ __('common.phone') }}:</b> +32 (0) 2 290 58 45
                        </div>
                        <div>
                            <b>{{ __('common.email') }}:</b> info(at)ecas.org
                        </div>
                        <div class="social-media">
                            <a href="https://www.facebook.com/pages/European-Citizen-Action-Service-ECAS/115314481819170?ref=hl"
                               title="Facebook" class="social-btn facebook" target="_blank"><i
                                        class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.linkedin.com/company/ecas-europe" title="LinkedIn"
                               class="social-btn linkedin"
                               target="_blank"><i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://twitter.com/ecas_europe" title="Twitter" class="social-btn twitter"
                               target="_blank"><i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.youtube.com/user/ECASBrussels/featured" title="Youtube"
                               class="social-btn youtube" target="_blank"><i class="fab fa-youtube"></i>
                            </a>
                            <a href="https://www.instagram.com/ecas_europe" title="Instagram"
                               class="social-btn instagram" target="_blank"><i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://ecas.org/feed/" title="RSS" class="social-btn rss" target="_blank"><span
                                        class="fas fa-rss"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 mx-sm-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <a href="https://ecas.org" target="_blank"><img loading="lazy" class="footer-logo"
                                                                                src="{{asset('images/projects/ecas/ecas_logo_scaled.png')}}"
                                                                                alt="ECAS logo"></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 d-flex align-items-center">
                                <img loading="lazy" class="w-100" src="{{asset('images/projects/ecas/eu-logo.png')}}"
                                     alt="European Union Logo">
                            </div>
                            <div class="col-md-6 col-sm-6 mt-3">
                                <p style="font-size:13px; line-height:20px; text-align: justify;">
                                    {!! __('common.footer_eu_text') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="lower-footer">
                        Copyright &copy; {{ date("Y") }} <a target=" _blank"
                                                            href="https://ecas.org">ECAS.org</a>
                        All rights reserved. | Version
                        <pre class="d-inline">{{ config("app.version")}}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

