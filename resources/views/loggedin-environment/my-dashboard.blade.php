@extends('loggedin-environment.layout')

@push('css')
    @vite('resources/assets/sass/pages/my-dashboard.scss')
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <h1>{{ __("common.welcome") }}, {{ $viewModel->user->nickname }}</h1>
        </div>
    </div>
    <div class="row gamification-box">
        <div class="col-md-12 mt-4 mb-4" style="float: none !important;">
            <div id="awards">
                @include('gamification.user-badges', ['badgesVM' => $viewModel->platformWideGamificationBadgesVM])
            </div>
        </div>
    </div>

    <div id="dashboard-actions-sections">
        <div class="container-fluid px-0">
            <div class="row">
                <div class="col">
                    <div class="accordion" id="projects-with-questionnaires">
                        <div class="card">
                            <div class="card-header" id="projects-with-questionnaires-header">
                                <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#projects-with-questionnaires-content"
                                   aria-expanded="true" aria-controls="faq1">{{ __('my-dashboard.contribution') }}</a>
                            </div>

                            <div id="projects-with-questionnaires-content" class="collapse show"
                                 aria-labelledby="projects-with-questionnaires-header" data-parent="#projects-with-questionnaires">
                                <div class="card-body px-2">
                                    @include('loggedin-environment.projects-with-active-questionnaires', ['questionnaires' => $viewModel->questionnaires])
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="projects-with-problems">
                                <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse"
                                   data-target="#faq2"
                                   aria-expanded="true" aria-controls="faq2">S.S.S</a>
                            </div>

                            <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                    richardson ad squid.
                                    3 wolf
                                    moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                    laborum
                                    eiusmod.
                                    Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                    nulla
                                    assumenda
                                    shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                    nesciunt
                                    sapiente ea
                                    proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                    farm-to-table, raw
                                    denim
                                    aesthetic synth nesciunt you probably haven't heard of them accusamus labore
                                    sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="faqhead3">
                                <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse"
                                   data-target="#faq3"
                                   aria-expanded="true" aria-controls="faq3">S.S.S</a>
                            </div>

                            <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                    richardson ad squid.
                                    3 wolf
                                    moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                                    laborum
                                    eiusmod.
                                    Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                                    nulla
                                    assumenda
                                    shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                    nesciunt
                                    sapiente ea
                                    proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                    farm-to-table, raw
                                    denim
                                    aesthetic synth nesciunt you probably haven't heard of them accusamus labore
                                    sustainable VHS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


