@if($viewModel->projectsWithActiveProblems->isEmpty())
    <p class="no-projects-found">{{ __("my-dashboard.no_projects_with_published_problems")}}</p>
@else
    @foreach($viewModel->projectsWithActiveProblems as $project)
        <div class="container-fluid project-section py-5 my-5" id="project-section-{{$project->id}}">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-center">{{ $project->currentTranslation->name }}</h5>
                </div>
            </div>
            <div class="row justify-content-center align-items-center my-2">
                <div class="col-12 text-center">
                    <div class="project-img-container">
                        <a href="{{ route('project.landing-page',$project->slug) }}">
                            <img loading="lazy" class="project-logo"
                                 alt="Project logo for {{$project->currentTranslation->name}}"
                                 src="{{asset($project->logo_path)}}">
                            <br>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center mt-3">
                <div class="col-12 text-center">
                    <a href="{{route("project.problems-page", $project->slug)}}"
                       class="btn btn-primary btn-lg nextStepActionBtn">{{ __('my-dashboard.see_the_problems_cta') }}</a>
                </div>
            </div>
        </div>
    @endforeach
@endif