@extends('backoffice.layout')

@section('content-header')
    <h1>{{ __("my-contributions.my_contributions")}}</h1>
@endsection

@push('css')
    @push('css')
        @vite('resources/assets/sass/pages/my-contributions.scss')
    @endpush
@endpush

@section('content')
    <div id="my-contributions">
        <div class="container-fluid px-0 pb-5">
            <div class="row">
                <div class="col">
                    <div class="accordion" id="my-questionnaire-contributions">
                        <div class="card">
                            <div class="card-header" id="questionnaires-header">
                                <a href="#" class="btn btn-header-link" data-toggle="collapse"
                                   data-target="#questionnaires-content"
                                   aria-expanded="true"
                                   aria-controls="questionnaires-content">{{ __('my-dashboard.questionnaires') }}</a>
                            </div>

                            <div id="questionnaires-content" class="collapse show"
                                 aria-labelledby="questionnaires-header"
                                 data-parent="#my-contributions">
                                <div class="card-body px-2">
                                    <p>{!! trans_choice("my-contributions.number_of_questionnaires",  $responses->count()  , [ "count" =>  $responses->count()  ]) !!}</p>

                                    @if($responses->isEmpty())
                                        <p class="warning">{{ __("my-contributions.no_questionnaires")}}</p>
                                    @else
                                        <table id="responsesTable" class="w-100 table table-striped table-bordered"
                                               cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>{{ __("my-contributions.project")}}</th>
                                                <th>{{ __("my-contributions.questionnaire_title")}}</th>
                                                <th>{{ __("my-contributions.questionnaire_description")}}</th>
                                                <th>{{ __("my-contributions.responded")}}</th>
                                                <th>{{ __("my-contributions.actions")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($responses as $response)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('project.landing-page', ['locale' => app()->getLocale(), 'slug' => $response->project_slug]) }}">
                                                            <div class="row">
                                                                <div class="col-lg-12 margin-bottom">{{ $response->project_name }}</div>
                                                                <div class="col-lg-12">
                                                                    <img loading="lazy" height="70"
                                                                         alt="{{$response->project_name}}"
                                                                         src="{{asset($response->project_logo_path)}}">
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>{{ $response->title }}</td>
                                                    <td>{!! $response->questionnaire_description !!}</td>
                                                    <td>{{ \Carbon\Carbon::parse($response->responded_at)->diffForHumans() }}</td>
                                                    <td class="align-middle">
                                                        <button class="btn btn-block btn-primary btn-slim viewResponseBtn"
                                                                data-responseid="{{ $response->questionnaire_response_id }}">
                                                            {{ __("my-contributions.view_response")}}
                                                        </button>
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
            <div class="row">
                <div class="col">
                    <div class="accordion" id="my-proposed-solutions">
                        <div class="card">
                            <div class="card-header" id="proposed-solutions-header">
                                <a href="#" class="btn btn-header-link" data-toggle="collapse"
                                   data-target="#proposed-solutions-content"
                                   aria-expanded="true"
                                   aria-controls="proposed-solutions-content">{{ __('my-contributions.my_proposed_solutions') }}</a>
                            </div>

                            <div id="proposed-solutions-content" class="collapse show"
                                 aria-labelledby="proposed-solutions-header"
                                 data-parent="#my-contributions">
                                <div class="card-body px-2">
                                    <p>{!! trans_choice("my-contributions.number_of_proposed_solutions",  $solutions->count()  , [ "count" =>  $solutions->count()  ]) !!}</p>

                                    @if($solutions->isEmpty())
                                        <p class="warning">{{ __("my-contributions.no_proposed_solutions")}}</p>
                                    @else
                                        <table id="proposedSolutionsTable"
                                               class="w-100 table table-striped table-bordered"
                                               cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>{{ __("my-contributions.problem") }}</th>
                                                <th>{{ __("solution.solution_title") }}</th>
                                                <th>{{ __("solution.solution_description") }}</th>
                                                <th>{{ __("solution.solution_image_label") }}</th>
                                                <th>{{ __("solution.number_of_votes_title") }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($solutions as $solution)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('problem.show', ['locale' => app()->getLocale(), 'project_slug' => $solution->problem->project->slug, 'problem_slug' => $solution->problem->slug]) }}">
                                                            <div class="row">
                                                                <div class="col-lg-12 margin-bottom">{{ $solution->problem->defaultTranslation->title }}</div>
                                                                <div class="col-lg-12">
                                                                    <img loading="lazy" height="70"
                                                                         alt="{{$solution->problem->defaultTranslation->title}}"
                                                                         src="{{asset($solution->problem->img_url)}}">
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>{{ $solution->defaultTranslation->title }}</td>
                                                    <td>{!! $solution->defaultTranslation->description !!}</td>
                                                    <td>
                                                        @if($solution->img_url)
                                                            <img loading="lazy" height="70"
                                                                 alt="{{$solution->defaultTranslation->title}}"
                                                                 src="{{ $solution->img_url }}">
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{!! $solution->upvotes->count() !!}</td>
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
    </div>
    @push("modals")
        <div id="questionnaireResponseModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="questionnaireTitle"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" id="questionnaire-display">
                        <div id="questionnaireResponse" class="survey-container"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endsection
@push('scripts')
    <script>
		const responses = Object.values(@json($responses));
    </script>
    @vite('resources/assets/js/pages/my-contributions.js')
@endpush
