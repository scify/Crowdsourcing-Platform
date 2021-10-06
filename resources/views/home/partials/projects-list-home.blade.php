<div class="projects-container container-fluid">
    <div class="row">
        @if(isset($projects))
            @foreach($projects as $project)
                <div class="col-md-6 col-xs-12">
                    <div class="project-wrapper">
                        <div class="project-logo">
                            <img loading="lazy" src="{{$project->logo_path}}" alt="">
                        </div>
                        <div class="project-info">
                            {!! $project->description ? $project->description : $project->about !!}
                        </div>
                        <div class="project-visit-btn">
                            <a href="/{{$project->slug}}" class="btn btn-block btn-primary btn-lg">
                                {{ isset($projectBtnText) ? $projectBtnText : 'Contribute' }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if(!isset($projects) || $projects->isEmpty())
            <div class="col-md-6 col-xs-12 mx-auto text-center">
                <h4>No active projects yet</h4>
            </div>
        @endif
    </div>
</div>
