<div class="container px-sm-0">

    <div class="row">
        <div class="col-12 my-2 pt-2">
            <x-go-back-link href="/{{ app()->getLocale() .'/'. $viewModel->project->slug }}"
                            class="d-none d-lg-block">{{ __("project-problems.back-to-the-campaign") }}</x-go-back-link>
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-lg-7">
            <h1 class="project-title">{{ __("project-problems.the_topic") }} {!! $viewModel->project->currentTranslation->name !!}</h1>
            <div class="project-overview pb-5 pb-lg-0">
                <br><p>{{ __("project-problems.start-contributing-directions") }}</p>
            </div>
        </div>

        <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
            <img src="/images/problems/problem-page-main@2x.png" alt="Problem image" class="img-fluid">
        </div>

    </div>

</div>
