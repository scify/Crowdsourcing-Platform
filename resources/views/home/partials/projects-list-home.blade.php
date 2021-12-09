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
                            {!! $project->currentTranslation->description ? : $project->currentTranslation->about !!}
                        </div>
                        <div class="project-visit-btn">
                            @if($project->latestQuestionnaire->status_id == \App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp::PUBLISHED)
                                <a href="/{{app()->getLocale() .'/'.$project->slug}}"
                                   class="btn btn-block btn-primary call-to-action action-dark">
                                    {{ isset($projectBtnText) ? $projectBtnText : 'Contribute' }}
                                </a>
                            @else
                                <a href="{{ route('questionnaire.statistics', $project->latestQuestionnaire->id) }}"
                                   class="btn btn-block btn-success call-to-action action-dark">Vote
                                </a>
                            @endif
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
