<div class="row" id="sitemap">
    <div class="col-md-6 col-sm-11 mx-auto">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="footer-grp">
                        <h3>ECAS Crowdsourcing Platform</h3>
                        <div>
                            <a href="#about">About</a>
                        </div>
                        <div>
                            <a href="#features">Features</a>
                        </div>
                        <div>
                            <a href="#projects">What are we crowdsourcing?</a>
                        </div>
                        <div>
                            <a href="https://ecas.org/about-us/" target="_blank">About us</a>
                        </div>
                        <div><a href="https://ecas.org/privacy-policy/" target="_blank">Our Privacy Policy</a></div>
                        <div>
                            <a href="{{ route('terms.privacy') }}" target="_blank">Platform Privacy Policy</a>
                        </div>
                        <div><a href="https://github.com/scify/Crowdsourcing-Platform" target="_blank">Github</a></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="footer-grp">
                        <h3>Get in touch</h3>
                        <div>
                            <b>Phone:</b> +32 (0) 2 548 04 90
                        </div>
                        <div>
                            <b>E-mail:</b> info(at)ecas.org
                        </div>
                        <div class="social-media">
                            <a href="https://www.facebook.com/pages/European-Citizen-Action-Service-ECAS/115314481819170?ref=hl"
                               title="Facebook" class="social-btn facebook" target="_blank"><i class="fab fa-facebook-f"></i>
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
                            <a href="https://ecas.org/feed/" title="RSS" class="social-btn rss" target="_blank"><span
                                        class="fas fa-rss"></span>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <a href="https://ecas.org" target="_blank"><img class="footer-logo"
                                                                    src="{{asset('images/projects/fair-eu/ecas_logo.png')}}"
                                                                    alt="ecas logo"></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-10 ml-auto eu-logo">
                    <img src="https://faireu.ecas.org/wp-content/uploads/2018/02/big-eu-flag.png" alt="">
                </div>
                <div class="col-md-6 col-sm-10 ml-auto">
                    <p style="font-size:13px; line-height:20px; text-align: justify;">
                        Project Co-funded by the JUSTICE, EQUALITY AND CITIZENSHIP PROGRAMME (2014-2020) OF THE EUROPEAN
                        UNION.<br>
                        The content of this website represents the views of the author only and is his/her sole
                        responsibility.
                        The European Commission does not accept any responsibility for use that may be made of the
                        information
                        it contains.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="lower-footer">
                        Copyright &copy; {{ date("Y") }} <a target=" _blank"
                                                            href="https://ecas.org">ECAS.org</a>
                        All rights reserved. | Version {{ env("APP_VERSION")}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

