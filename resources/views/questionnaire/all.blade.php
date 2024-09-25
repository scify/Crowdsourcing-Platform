@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Manage Questionnaires</h1>
@endsection

@push('css')
    @vite('resources/assets/sass/questionnaire/manage-questionnaires.scss')
@endpush

@section('content')
    <div class="row manage-questionnaires">
        <div class="col-md-12 col-xs-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">All questionnaires</h3>
                </div>
                <div class="card-body">
                    <div class="row margin-bottom">
                        <div class="col-md-2">
                            <a class="btn btn-block btn-primary new-questionnaire"
                               href="{{route("create-questionnaire")}}"><i
                                        class="fa fa-plus"></i> Create new questionnaire</a>
                        </div>
                    </div>
                    <table class="w-100 table table-striped table-bordered" id="questionnaires-table" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Title</th>
                            <th>Projects</th>
                            <th>Responses / Goal</th>
                            <th>Languages</th>
                            <th>Status</th>
                            <th class="text-center">Order</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($viewModel->questionnaires as $questionnaire)
                            <tr data-id="{{$questionnaire->id}}" data-title="{{$questionnaire->title}}"
                                data-status="{{$questionnaire->status_id}}">
                                <td class="text-center">{{ $loop->index + 1 }}</td>
                                <td>{{$questionnaire->title}}</td>
                                <td>{{ $questionnaire->project_names }}</td>
                                <td>
                                    @if($questionnaire->goal)
                                        {{ $questionnaire->number_of_responses ?? 0 }} / {{ $questionnaire->goal }}
                                        <b>({{ round(($questionnaire->number_of_responses / $questionnaire->goal) * 100, 1) }}
                                            %)</b>
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    <b>{{$questionnaire->default_language_name}}</b>{{ $questionnaire->languages? ', ' : '' }}{{$questionnaire->languages}}
                                </td>
                                <td>
                                        <span class="badge {{$viewModel->setCssClassForStatus($questionnaire->status_id)}}"
                                              title="{{$questionnaire->status_description}}">{{$questionnaire->status_title}}</span>
                                </td>
                                <td class="text-center">{{ $questionnaire->prerequisite_order }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                data-toggle="dropdown">Select an action
                                            <span class="caret"></span></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can("manage-platform-content")
                                                @if (!$viewModel->isQuestionnaireArchived($questionnaire))
                                                    <a class="action-btn dropdown-item"
                                                       href="{{route('edit-questionnaire', ['id' => $questionnaire->id])}}"><i
                                                                class="far fa-edit"></i> Edit Questionnaire</a>
                                                @endif
                                            @endcan
                                            @can("manage-platform-content")
                                                <a class="action-btn dropdown-item"
                                                   href="{{route('questionnaire.statistics-colors', ['questionnaire' => $questionnaire->id])}}"><i
                                                            class="fas fa-palette"></i> Basic Statistics Colors</a>
                                            @endcan
                                            @if(isset($questionnaire->urls))
                                                @if(count($questionnaire->urls) === 1)
                                                    <button data-clipboard-text="{{ $questionnaire->urls[0]['url'] }}"
                                                            class="copy-clipboard action-btn dropdown-item">
                                                        <i class="copy-questionnaire-link fa fa-link"></i> Get English
                                                        Link
                                                    </button>
                                                @else
                                                    @foreach($questionnaire->urls as $url)
                                                        <button data-clipboard-text="{{ $url['url'] }}"
                                                                class="copy-clipboard action-btn dropdown-item">
                                                            <i class="copy-questionnaire-link fa fa-link"></i>
                                                            Get {{ $url['project_name'] }} English Link
                                                        </button>
                                                    @endforeach
                                                @endif
                                            @endif
                                            @if (!$viewModel->isQuestionnaireArchived($questionnaire) && $questionnaire->project_slugs)
                                                @foreach(explode(",", $questionnaire->project_slugs) as $project_slug)
                                                    <a class="action-btn dropdown-item"
                                                       href="{{route('questionnaire-moderator-add-response',
                                                        ['questionnaire' => $questionnaire->id, 'project' => $project_slug])}}"><i
                                                                class="fas fa-plus"></i> Add Response
                                                        | {{ explode(",", $questionnaire->project_names)[$loop->index] }}
                                                    </a>
                                                @endforeach
                                            @endif
                                            <hr>
                                            <a class="action-btn dropdown-item"
                                               href="{{route('questionnaires.reports', ['questionnaireId' => $questionnaire->id])}}"><i
                                                        class="fas fa-list-ul"></i> Results Report</a>
                                            <a class="action-btn dropdown-item"
                                               target="_blank"
                                               href="{{route('questionnaire.statistics', ['questionnaire' => $questionnaire->id])}}">
                                                <i class="fas fa-chart-pie"></i> Statistics</a>
                                            @can('manage-platform-content')
                                                <hr>
                                                <a class="action-btn dropdown-item change-status"
                                                   href="javascript:void(0)"
                                                   data-toggle="modal"
                                                   data-target="#changeStatusModal"><i class="fa fa-cog"></i> Change
                                                    status</a>
                                            @endcan
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
@endsection

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
    @vite('resources/assets/js/questionnaire/manage-questionnaires.js')
@endpush
