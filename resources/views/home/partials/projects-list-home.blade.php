<div class="projects-container row">
    @foreach($projects as $project)
        <div class="col-md-6 col-xs-12">
            <div class="project-wrapper">
                <div class="project-logo">
                    <img src="{{$project->logo_path}}" alt="">
                </div>
                <div class="project-info">
                    {!! $project->description !!}
                </div>
                <div class="project-visit-btn">
                    <a href="/{{$project->slug}}" class="btn btn-block btn-primary">Contribute</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
