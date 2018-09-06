<div class="row">
    <div class="col-md-12">
        <table id="resultsTable">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Question</th>
                    <th>Answer (color indicates answer entered by the respondent)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportViewModel->resultRows as $row)
                    <tr>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->nickname }}</td>
                        <td>{{ $row->question }}</td>
                        <td class="{{ $row->text_answer ? 'colored' : '' }}">{{ $row->answer ? $row->answer : $row->text_answer }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
    {{--  todo: find nmp alternatives for these  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>--}}
    <script src="{{mix('dist/js/questionnaire-report.js')}}"></script>

@endpush