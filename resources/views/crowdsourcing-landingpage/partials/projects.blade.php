<div class="row">
    <div class="col-md-12">
        <h2>Projects</h2>
        <div class="content-container">
            <p>In the present platform, a lot of different projects are hosted. Below, there is a list of all the
                currently active ones. You may click on any item of the list to visit the project's page and
                contribute.</p>
            <div class="projects-container row">
                @foreach($projects as $project)
                    <div class="col-md-4">
                        <div class="project-wrapper" title="{{$project->name}}">
                            <div class="project-logo">
                                <img src="{{$project->logo_path}}" alt="">
                            </div>
                            <div class="project-info">
                                {!! $project->about !!}
                            </div>
                            <div class="project-visit-btn">
                                <a href="/{{$project->slug}}" class="btn btn-block btn-primary">Visit project's page</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>