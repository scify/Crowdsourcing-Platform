<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Respondents Report</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <table id="usersTable">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th class="text-center">Question id</th>
                        <th>Question text</th>
                        <th class="text-center">Answer id</th>
                        <th>Answer text (color indicates answer entered by the respondent)</th>
                        <th>Answer automatic translation</th>
                        <th>Answer initial language detected</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reportViewModel->usersRows as $row)
                        <tr>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->nickname }}</td>
                            <td class="text-center">{{ $row->question_id }}</td>
                            <td>{{ $row->question }}</td>
                            <td class="text-center">{{ $row->answer_id }}</td>
                            <td class="{{ $row->text_answer ? 'colored' : '' }}">{{ $row->text_answer ? $row->text_answer : $row->answer }}</td>
                            <td>{{ $row->answer_english_translation }}</td>
                            <td>{{ $row->answer_initial_language_detected }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Answers Report</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="answerStats">
                    <table id="answersTable">
                        <thead>
                        <tr>
                            <th>Question id</th>
                            <th>Question text</th>
                            <th>Answer id</th>
                            <th>Answer text (color indicates answer entered by the respondent)</th>
                            <th>Answer automatic translation</th>
                            <th>Answer initial language detected</th>
                            <th>Number of occurrences</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reportViewModel->answersRows as $row)
                            <tr>
                                <td class="text-center">{{ $row->question_id }}</td>
                                <td>{{ $row->question }}</td>
                                <td class="text-center">{{ $row->answer_id }}</td>
                                <td class="{{ $row->text_answer ? 'colored' : '' }}">{{ $row->answer ? $row->answer : $row->text_answer }}</td>
                                <td>{{ $row->answer_english_translation }}</td>
                                <td>{{ $row->answer_initial_language_detected }}</td>
                                <td>{{ $row->num_of_times }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    {{--  todo: find nmp alternatives for these  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>--}}
    <script src="{{mix('dist/js/questionnaire-report.js')}}"></script>

@endpush