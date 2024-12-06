@extends('backoffice.layout')

@section('content-header')
    <h1>{{ __("my-history.my_contributions")}}</h1>
@endsection

@push('css')
    @push('css')
        @vite('resources/assets/sass/pages/my-contributions.scss')
    @endpush
@endpush

@section('content')
    <div id="my-contributions">
        <div class="container-fluid px-0">
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
                                    <p>{!! trans_choice("my-history.number_of_questionnaires",  $responses->count()  , [ "count" =>  $responses->count()  ]) !!}</p>

                                    @if($responses->isEmpty())
                                        <p class="warning">{{ __("my-history.no_questionnaires")}}</p>
                                    @else
                                        <table id="responsesTable" class="w-100 table table-striped table-bordered"
                                               cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>{{ __("my-history.project")}}</th>
                                                <th>{{ __("my-history.questionnaire_title")}}</th>
                                                <th>{{ __("my-history.questionnaire_description")}}</th>
                                                <th>{{ __("my-history.responded")}}</th>
                                                <th>{{ __("my-history.actions")}}</th>
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
                                                            {{ __("my-history.view_response")}}
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
    @vite('resources/assets/js/questionnaire/my-questionnaire-responses.js')
@endpush
