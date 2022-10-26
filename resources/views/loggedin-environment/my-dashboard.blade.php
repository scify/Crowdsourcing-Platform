@extends('loggedin-environment.layout')

@push('css')
    <link rel="preload" href="{{ mix('dist/css/my-dashboard.css') }}" as="style"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ mix('dist/css/my-dashboard.css') }}">
    </noscript>
@endpush

@section('content')
    <div class="row gamification-box">
        <div class="col-md-12 mt-4 mb-4" style="float: none !important;">
            <div id="awards">
                @include('gamification.user-badges', ['badgesVM' => $viewModel->platformWideGamificationBadgesVM])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ __("my-dashboard.contribution") }}. {{ __("badges_messages.get_more_badges") }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="container-fluid table-responsive">
                                @if($viewModel->questionnaires->isEmpty())
                                    <div class="no-projects-found">{{ __("questionnaire.no_active_projects")}}
                                    </div>
                                @else
                                    <table id="available-projects"
                                           class="w-100 row table table-striped table-hover table-responsive-md">
                                        <tbody class="w-100">
                                        @foreach($viewModel->questionnaires as $questionnaire)
                                            <tr class="d-flex flex-wrap justify-content-center">
                                                <td class="h-75 col-md-4 col-sm-6 justify-content-center align-self-center border-top-0">
                                                    <div class="container-fluid">

                                                        <h4>  {{ $questionnaire->fieldsTranslation->title }}</h4>
                                                        @if ($questionnaire->type_id==2)
                                                            <a href="{{ route('project.landing-page',$questionnaire->projects[0]->slug) }}">
                                                                <img loading="lazy" class="project-logo" style="max-height:70px;"
                                                                     alt="Project logo for {{$questionnaire->projects[0]->defaultTranslation->name}}"
                                                                     src="{{asset($questionnaire->projects[0]->logo_path)}}">
                                                                <br>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="h-75 col-md-4 col-sm-12 justify-content-center align-self-center border-top-0">
                                                    @include('gamification.next-step', ['nextStepVM' => $questionnaire->gamificationNextStepVM])
                                                </td>
                                                <td class="h-75 col-md-4 col-sm-6 justify-content-center align-self-center border-top-0">
                                                    @if ($questionnaire->type_id==1)
                                                        <div class="progress-container">
                                                            @include('landingpages.partials.project-goal',
                                                            ['questionnaireId' => $questionnaire->id, 'questionnaireViewModel' => $questionnaire->goalVM, 'project' => $questionnaire->projects->get(0)])
                                                            @if ($questionnaire->userHasAccessToViewStatisticsPage)
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <a class="btn btn-primary" target="_blank"
                                                                           href="{{ route('questionnaire.statistics', $questionnaire) }}">
                                                                            <i class="fas fa-chart-pie mr-2"></i> {{ __("my-dashboard.view_statistics")}}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
