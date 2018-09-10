@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/my-questionnaire-responses.css') }}">
    <link href="{{asset('dist/css/survey.css')}}" type="text/css" rel="stylesheet"/>
@endpush


@if($responses->isEmpty())
    <p class="warning">You haven't responded to any questionnaires, yet.</p>
@else
    <table id="responsesTable">
        <thead>
        <tr>
            <th>Questionnaire title</th>
            <th>Questionnaire description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach($responses as $response)
                <tr>
                    <td>{{ $response->title }}</td>
                    <td>{!! $response->description !!}</td>
                    <td><button class="btn btn-block btn-primary viewResponseBtn" data-responseid="{{ $response->questionnaire_response_id }}">View response</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@push("modals")
<div id="questionnaireResponseModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="questionnaireTitle"></h3>
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

@push('scripts')
    <script src="{{ mix('dist/js/myQuestionnaireResponses.js')}}?{{env("APP_VERSION")}}"></script>
    <script type="text/javascript">
        let responses = {!! json_encode($responses) !!};
        let controller = new QuestionnaireResponsesController(responses);
        controller.init();
    </script>
@endpush
