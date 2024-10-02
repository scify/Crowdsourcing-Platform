<div class="container px-sm-0">

    <div class="row">
        <div class="col-12 my-4 my-lg-5 pt-4">
            <x-go-back-link href="/{{ app()->getLocale() .'/'. $viewModel->project->slug }}" class="d-none d-lg-block">{{ __("project-problems.back") }}</x-go-back-link> <!-- bookmark - app()->getLocale() // is this OK? -->
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-lg-7">
            <h1 class="project-title">{{ __("project-problems.the_topic") }} {{ $viewModel->project->currentTranslation->name }}</h1>
            <div class="project-overview pb-5 pb-lg-0">
                {!! $viewModel->project->currentTranslation->about !!}
            </div>
        </div>

        <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
            <img src="/images/problems/problem-page-main.png" alt="" width="384" height="416" class="img-fluid">
        </div>

    </div>

</div>
