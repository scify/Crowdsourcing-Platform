@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Manage Questionnaires</h1>
@stop

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/manage-questionnaires.css')}}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">All questionnaires</h3>
                </div>
                <div class="box-body">
                    <a class="btn btn-block btn-primary new-questionnaire" href="{{route("create-questionnaire")}}"><i
                                class="fa fa-plus"></i> Create new questionnaire</a>
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Languages available</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($viewModel->questionnaires as $questionnaire)
                            <tr data-id="{{$questionnaire->id}}" data-title="{{$questionnaire->title}}"
                                data-status="{{$questionnaire->status_id}}">
                                <td>{{$questionnaire->id}}</td>
                                <td>{{$questionnaire->title}}</td>
                                <td>
                                    <b>{{$questionnaire->default_language_name}}</b>{{count($questionnaire->languages) > 0 ? ', ' : ''}}
                                    {{implode(', ', $questionnaire->languages)}}
                                </td>
                                <td>
                                    <span class="label {{$questionnaire->status_css_class}}"
                                          title="{{$questionnaire->status_description}}">
                                        {{$questionnaire->status_title}}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <a href="{{route('edit-questionnaire', ['id' => $questionnaire->id])}}">Edit questionnaire</a>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)" class="change-status" data-toggle="modal"
                                           data-target="#changeStatusModal">Change status</a>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change status for "<span id="questionnaire-title"></span>"</h4>
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
                        <div class="row">
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