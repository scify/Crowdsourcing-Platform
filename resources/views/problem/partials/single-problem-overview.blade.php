<div class="container px-sm-0">
    <div class="row">
        <div class="col-12 my-2 pt-2">
            <x-go-back-link href="/{{ app()->getLocale() . '/' . $viewModel->project->slug . '/problems' }}"
                class="d-none d-lg-block">{{ __('project-problems.back-to-the-problems') }}</x-go-back-link>
        </div>
    </div>
    <div class="row problem-description align-items-center">
        <div class="col-12 col-lg-7 d-flex flex-column">
            <h1 class="section-title">{{ __('problem.solutions_for') }} {!! $viewModel->problem->currentTranslation->title !!}</h1>
            <div class="section-body pb-5 pb-lg-0">
                <p>{!! $viewModel->problem->currentTranslation->description !!}</p>
            </div>
        </div>
        <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
            <img src="/images/problems/problem-page-intro-top-question@2x.png" alt="" class="img-fluid">
        </div>
    </div>
    <div class="row how-to-vote align-items-center">
        <div class="col-12 col-lg-7 d-flex flex-column">
            <h2 class="section-title">{{ __('problem.how_to_vote') }}</h2>
            <div class="section-body pb-5 pb-lg-0">
                <p>{!! __('voting.you_can_vote_up_to', [
                    'votes' => $viewModel->project->max_votes_per_user_for_solutions,
                    'entityName' => __('voting.entity_solutions'),
                ]) !!}</p>
                <p>{{ __('problem.how_to_vote_text') }}</p>
            </div>
        </div>
        <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
            <img src="/images/problems/problem-page-intro-top-thinking@2x.png" alt="" class="img-fluid">
        </div>
    </div>
</div>
