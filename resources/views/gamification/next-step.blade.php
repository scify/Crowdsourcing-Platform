@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/next-step.css') }}">
@endpush
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">What to do next?</h3>
    </div>
    <div class="box-body">
        <div class="row nextStepContainer">
            <div class="col-md-12">
                <h4>{{ $nextStepVM->title }}</h4>
                <h5>{{ $nextStepVM->subtitle }}</h5>
                <div class="nextStepImgContainer">
                    <img class="nextStepImg" src="{{asset("images/badges/" . $nextStepVM->imgFileName)}}">
                </div>
            </div>
            <div class="col-md-12">
                <a href="{{url("/" . $nextStepVM->project->slug . "#questionnaire")}}" class="btn btn-primary btn-lg nextStepActionBtn">Go to Questionnaire</a>
            </div>
        </div>
    </div>
</div>