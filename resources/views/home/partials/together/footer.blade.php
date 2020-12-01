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
                            <a href="https://www.scify.gr/site/en/who-we-are/scify" target="_blank">About us</a>
                        </div>
                        <div><a href="https://www.scify.gr/site/en/impact-areas-en" target="_blank">Impact Areas</a>
                        </div>
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
                            <b>Phone:</b> +30 211 4004 192
                        </div>
                        <div>
                            <b>E-mail:</b> info(at)scify.org
                        </div>
                        <div class="social-media">
                            <a href="https://www.facebook.com/SciFY.org"
                               title="Facebook" class="social-btn facebook" target="_blank"><i
                                        class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.linkedin.com/company/2894834/" title="LinkedIn"
                               class="social-btn linkedin"
                               target="_blank"><i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://twitter.com/scify_org" title="Twitter" class="social-btn twitter"
                               target="_blank"><i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.youtube.com/user/SciFYNPO" title="Youtube"
                               class="social-btn youtube" target="_blank"><i class="fab fa-youtube"></i>
                            </a>
                            <a href="https://www.scify.gr/site/en/blog" title="Blog" class="social-btn rss"
                               target="_blank"><span
                                        class="fas fa-rss"></span>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12 mx-auto">
                    <a href="https://ecas.org" target="_blank"><img class="footer-logo"
                                                                    src="{{asset('images/SciFY_logo_256.png')}}"
                                                                    alt="ecas logo"></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-10 ml-auto eu-logo">
                    <img src="https://faireu.ecas.org/wp-content/uploads/2018/02/big-eu-flag.png" alt="">
                </div>
                <div class="col-md-6 col-sm-10 ml-auto">
                    <p style="font-size:13px; line-height:20px; text-align: justify;">
                        The initial version of the project was Co-funded by the JUSTICE, EQUALITY AND CITIZENSHIP PROGRAMME
                        (2014-2020) OF THE EUROPEAN
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
                                                            href="https://scify.org/en">SciFY</a>
                        All rights reserved. | Version {{ env("APP_VERSION")}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

