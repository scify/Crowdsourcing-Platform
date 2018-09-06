<div class="row">
    <div class="col-md-12">
        <h2>What are we crowdsourcing?</h2>
        <div class="content-container">
            <p>ECAS crowdsourcing platform hosts various projects. Please check below those
                that are the currently active and waiting for your contribution.
                Please visit a project's page and make an impact by answering just a couple of questions!</p>
            <div class="projects-container row">
                @foreach($projects as $project)
                    <div class="col-md-4 col-sm-6 col-xs-10 col-xs-offset-1 col-sm-offset-0 col-md-offset-0">
                        <div class="project-wrapper">
                            <div class="project-logo">
                                <img src="{{$project->logo_path}}" alt="">
                            </div>
                            <div class="project-info">
                                {!! $project->about !!}
                            </div>
                            <div class="project-visit-btn">
                                <a href="/{{$project->slug}}" class="btn btn-block btn-primary">Contribute</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>