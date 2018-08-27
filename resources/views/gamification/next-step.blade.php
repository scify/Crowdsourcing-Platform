<div class="row nextStepContainer">
    <div class="col-md-12">
        <h4>{{ $nextStepVM->title }}</h4>
        <h5>{{ $nextStepVM->subtitle }}</h5>
        <div class="nextStepImgContainer">
            <img class="nextStepImg" src="{{asset("images/badges/" . $nextStepVM->imgFileName)}}">
        </div>
    </div>
</div>