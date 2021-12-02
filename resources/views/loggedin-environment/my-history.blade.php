@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{ __("my-history.my_contributions")}}</h1>
@endsection

@push('css')
    @push('css')
        <link rel="stylesheet" href="{{ mix('dist/css/my-questionnaire-responses.css') }}">
    @endpush
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{ __("my-history.number_of_questionnaires")}} {{ $responses->count() }} {{ str_plural('questionnaire', $responses->count())}}</h3>
                </div>
                <div class="card-body">
                    @if($responses->isEmpty())
                        <p class="warning">{{ __("my-history.no_questionnaires")}}</p>
                    @else
                        <table id="responsesTable" class="w-100 table table-striped table-bordered" cellspacing="0">
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
                                        <a href="{{ url('/' . $response->slug) }}">
                                            <div class="row">
                                                <div class="col-lg-12 margin-bottom">{{ $response->name }}</div>
                                                <div class="col-lg-12">
                                                    <img loading="lazy" height="70" alt="{{$response->name}}"
                                                         src="{{asset($response->logo_path)}}">
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $response->title }}</td>
                                    <td>{!! $response->questionnaire_description !!}</td>
                                    <td>{{ \Carbon\Carbon::parse($response->responded_at)->diffForHumans() }}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-block btn-primary viewResponseBtn"
                                                data-responseid="{{ $response->questionnaire_response_id }}">
                                            View response{{ __("my-history.view_response")}}
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
    @push("modals")
        <div id="questionnaireResponseModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="questionnaireTitle"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="questionnaireResponse"></div>
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
    <script src="{{ mix('dist/js/myQuestionnaireResponses.js')}}"></script>
    <script type="text/javascript">
        let responses = Object.values(@json($responses));
        let controller = new QuestionnaireResponsesController(responses);
        controller.init();
    </script>
@endpush
