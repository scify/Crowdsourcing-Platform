@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Manage Questionnaires</h1>
@stop

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/manage-questionnaires.css')}}">
@endpush

@section('content')
    <div class="row manage-questionnaires">
        <div class="col-md-12 col-xs-12">
            <div class="card card-info">
                <div class="card-header with-border">
                    <h3 class="card-title">All questionnaires</h3>
                </div>
                <div class="card-body">
                    <div class="row margin-bottom">
                        <div class="col-md-2">
                            <a class="btn btn-block btn-primary new-questionnaire" href="{{route("create-questionnaire")}}"><i
                                        class="fa fa-plus"></i> Create new questionnaire</a>
                        </div>
                    </div>
                    <table class="table table-striped" id="questionnaires-table" cellspacing="0" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Project</th>
                            <th>Goal / Responses</th>
                            <th>Languages available</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($viewModel->questionnaires as $questionnaire)
                                <tr data-id="{{$questionnaire->id}}" data-title="{{$questionnaire->title}}"
                                    data-status="{{$questionnaire->status_id}}">
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{$questionnaire->title}}</td>
                                    <td>{{ $questionnaire->project_name }}</td>
                                    <td>{{ $questionnaire->goal }} / {{ $questionnaire->number_of_responses }} ({{ ($questionnaire->number_of_responses / $questionnaire->goal) * 100 }}%)</td>
                                    <td>
                                        <b>{{$questionnaire->default_language_name}}</b>
                                        {{--{{count($questionnaire->languages) > 0 ? ', ' : ''}}--}}
                                        {{$questionnaire->languages}}
                                    </td>
                                    <td>
                                        <span class="label {{$viewModel->setCssClassForStatus($questionnaire->status_title)}}"
                                              title="{{$questionnaire->status_description}}">{{$questionnaire->status_title}}</span>
                                    </td>
                                    <td>{{ $questionnaire->prerequisite_order }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select an action
                                                <span class="caret"></span></button>
                                            <div class="dropdown-menu">
                                                <a class="action-btn dropdown-item" href="{{route('edit-questionnaire', ['id' => $questionnaire->id])}}"><i class="far fa-edit"></i> Edit questionnaire</a>
                                                <a class="action-btn dropdown-item" href="{{route('translate-questionnaire', ['id' => $questionnaire->id])}}"><i class="fa fa-language"></i> Translate</a>
                                                <a class="action-btn dropdown-item" href="{{route('project.reports', ['id' => $questionnaire->project_id, 'questionnaireId' => $questionnaire->id])}}"><i class="fas fa-list-ul"></i> View Results</a>
                                                <a class="action-btn dropdown-item change-status" href="javascript:void(0)" data-toggle="modal"
                                                   data-target="#changeStatusModal"><i class="fa fa-cog"></i> Change status</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('modals')
    <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change status for Questionnaire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('update-questionnaire-status')}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="modal-body">
                        <input type="hidden" name="questionnaire_id" id="questionnaire-id">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <select name="status_id" id="status-select" class="form-control">
                                    @foreach($viewModel->statuses as $status)
                                        <option value="{{$status->id}}">{{$status->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="col-md-12 form-group">
                                <textarea name="comments" id="comments" class="form-control" cols="30"
                                          rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script src="{{asset('/dist/js/manageQuestionnaires.js')}}"></script>
@endpush
