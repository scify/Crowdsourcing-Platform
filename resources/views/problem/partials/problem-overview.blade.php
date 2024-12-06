<div class="container px-sm-0">

    <div class="row">
        <div class="col-12 my-4 my-lg-5 pt-4">
            <x-go-back-link href="/{{ app()->getLocale() .'/'. $viewModel->project->slug }}"
                            class="d-none d-lg-block">{{ __("project-problems.back") }}</x-go-back-link>
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-lg-7">
            <h2 class="project-title">{{ __("problem.solutions_for") }} {{ $viewModel->problem->currentTranslation->title }}</h2>
            <div class="project-overview pb-5 pb-lg-0">
                {!! $viewModel->problem->currentTranslation->description !!}
            </div>
        </div>

        <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
            <img src="/images/problems/problem-page-intro-top-question.png" alt="" width="384" height="416" class="img-fluid">
        </div>

    </div>

    <div class="row">
        <div class="col-12 col-lg-7">
            <h2 class="project-title">{{ __("problem.how_to_vote") }}</h2>
            <div class="project-overview pb-5 pb-lg-0">
                {{ __("problem.how_to_vote_text") }}
            </div>
        </div>

        <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
            <img src="/images/problems/problem-page-intro-top-thinking.png" alt="" width="384" height="416" class="img-fluid">
        </div>
    </div>
</div>
