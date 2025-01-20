<div class="container px-sm-0">

    <div class="row">
        <div class="col-12 my-4 my-lg-5 pt-4">
            <x-go-back-link href="/{{ app()->getLocale() .'/'. $viewModel->project->slug . '/problems' }}"
                            class="d-none d-lg-block">{{ __("project-problems.back-to-the-problems") }}</x-go-back-link>
        </div>
    </div>

    <div class="row problem-description">

        <div class="col-12 col-lg-7">
            <h1 class="section-title">{{ __("problem.solutions_for") }} {{ $viewModel->problem->currentTranslation->title }}</h1>
            <div class="section-body pb-5 pb-lg-0">
                <p>{!! $viewModel->problem->currentTranslation->description !!}</p>
            </div>
        </div>

        <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
            <img src="/images/problems/problem-page-intro-top-question@2x.png" alt="" width="382" height="238" class="img-fluid">
        </div>

    </div>

    <div class="row how-to-vote">

        <div class="col-12 col-lg-7">
            <h2 class="section-title">{{ __("problem.how_to_vote") }}</h2>
            <div class="section-body pb-5 pb-lg-0">
                <p>{{ __("problem.how_to_vote_text") }}</p>
            </div>
        </div>

        <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
            <img src="/images/problems/problem-page-intro-top-thinking@2x.png" alt="" width="384" height="344" class="img-fluid">
        </div>

    </div>

</div>
