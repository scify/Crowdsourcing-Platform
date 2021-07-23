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
                        <th>Email</th>
                        <th>Answered at</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reportViewModel->respondentsRows as $row)
                        <tr>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->answered_at }}</td>
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
        <h3 class="card-title">Respondents Analytic Report</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table id="usersTable" cellspacing="0" class="w-100 table table-striped table-bordered">
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
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Answers Report</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div id="questionnaire-responses-report"></div>
            </div>
        </div>
    </div>
</div>
