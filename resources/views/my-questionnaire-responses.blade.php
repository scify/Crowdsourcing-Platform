@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/my-questionnaire-responses.css') }}">
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
                    <td><button class="btn btn-block btn-primary">View response</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@push('scripts')
    <script src="{{ mix('dist/js/myQuestionnaireResponses.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
