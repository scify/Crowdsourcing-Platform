<div class="projects-container container-fluid">
    <div class="row">
        @if(isset($projects))
            @foreach($projects as $project)
                <div class="col-md-6 col-xs-12">
                    <div class="project-wrapper">
                        <div class="project-logo">
                            <img loading="lazy" src="{{$project->logo_path}}" alt="logo of the project">
                        </div>
                        <div class="project-info">
                            <h4 class="text-center">{!! $project->currentTranslation->name !!}</h4>
                            <p>{!! $project->currentTranslation->motto_title !!}</p>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-12 mx-auto">
                                    <div class="project-visit-btn">
                                        @if(($project->latestQuestionnaire && $project->latestQuestionnaire->status_id == \App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp::PUBLISHED) || $project->problems && $project->problems->count() > 0)
                                            <a href="{{ route('project.landing-page', ['locale' => app()->getLocale(), 'slug' => $project->slug]) }}"
                                               class="btn btn-block btn-primary call-to-action action-dark">
                                                {{ __('badges_messages.contribute') }}
                                            </a>
                                        @else
                                            <a href="{{ route('project.landing-page', ['locale' => app()->getLocale(), 'slug' => $project->slug]) }}"
                                               class="btn btn-block btn-success call-to-action action-success">
                                                {{ __('common.view_campaign') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if(!isset($projects) || $projects->isEmpty())
            <div class="col-md-6 col-xs-12 mx-auto text-center">
                <h4>
                    {{ __('common.no_active_projects') }}
                </h4>
            </div>
        @endif
    </div>
</div>
