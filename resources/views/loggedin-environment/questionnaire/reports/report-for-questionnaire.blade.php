<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Statistics</h3>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-12">
                Click <a
                        href="{{ route('questionnaire.statistics', ['questionnaire' =>  $reportViewModel->questionnaireId, 'locale' => app()->getLocale() ]) }}"
                        target="_blank">here</a> to view and moderate the responses.
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                Click <a
                        href="{{ route('questionnaire.responses.download', ['questionnaire_id' =>  $reportViewModel->questionnaireId ]) }}"
                        target="_blank">here</a> to download the votes for open-ended questions.
            </div>
        </div>
    </div>
</div>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Response counter</h3>
    </div>
    <div class="card-body">
        <div class="row mt-6">
            <div class="col-12 ">
                <table class="table">
                    <tr>
                        <th>Page</th>
                        <th>Number of Answers</th>
                    </tr>
                    @foreach($reportViewModel->countResponses as $response)
                        <tr>
                            <td><a href="{{$response->slug}}" target="_blank">{{$response->slug}}</a></td>
                            <td>{{$response->total}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Respondents Summary</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table id="respondentsTable" class="w-100 table table-striped table-bordered" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Email/Name</th>
                        <th>Answered at</th>
                        <th>Related Project</th>
                        <th class="text-center">Response</th>
                        @can("manage-platform-content")
                            <th class="text-center">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reportViewModel->respondentsRows as $response)
                        <tr id="questionnaire_response_{{ $response->id }}">
                            <td>{{ $response->respondent_email }} / {{ $response->respondent_nickname }}</td>
                            <td data-sort="{{ strtotime($response->answered_at) }}">{{ $response->answered_at ? date('d/m/Y h:i:s', strtotime($response->answered_at)) : '' }}</td>
                            <td class="">
                                {{ $response->project_name }}
                            </td>
                            <td class="text-center">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-outline-primary response-btn w-100"
                                                    data-respondent-user-data="{{ $response->respondent_email . ' / ' . $response->respondent_nickname }}"
                                                    data-respondent-user-id="{{ $response->respondent_user_id }}">View
                                                Response
                                            </button>
                                        </div>
                                        {{--                                        <div class="col-6">--}}
                                        {{--                                            <button class="btn btn-outline-primary response-table-btn w-100"--}}
                                        {{--                                                    data-respondent-user-data="{{ $response->respondent_email . ' / ' . $response->respondent_nickname }}"--}}
                                        {{--                                                    data-respondent-user-id="{{ $response->respondent_user_id }}">View--}}
                                        {{--                                                Table--}}
                                        {{--                                            </button>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                </div>

                            </td>
                            @can("manage-platform-content")
                                <td class="text-center">
                                    <button class="btn btn-outline-danger delete-response-btn"
                                            data-questionnaire-response-id="{{ $response->id }}">Delete
                                    </button>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Answers </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div id="questionnaire-responses-report" class="responses-report"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal-overflow">
    <div class="modal fade" id="respondent-answers-modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Answers for user: <b
                                id="respondent-answers-modal-title"></b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="respondent-answers-panel" style="height: 80vh;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div class="modal fade" id="respondent-answers-table-modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Answers for user: <b
                                id="respondent-answers-table-modal-title"></b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="respondent-answers-table-panel" class="responses-report"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="delete-response-modal" class="modal fade">
    <div class="modal-dialog" style="margin-top: 10%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __("my-account.are_you_sure") }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p class="text-danger"><b>Waring:</b> This action will delete the response.
                    <br><br>
                    <b>This action cannot
                        be undone.</b></p>
                <p id="delete-response-error" class="mt-3"></p>
            </div>
            <div class="modal-footer">
                <form role="form" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="questionnaire_response_id">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="delete-response-form-btn" type="button" class="btn btn-danger">
                        Delete<span id="delete-response-loader" class="spinner-border spinner-border-sm ml-2 d-none"
                                    role="status"
                                    aria-hidden="true"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
