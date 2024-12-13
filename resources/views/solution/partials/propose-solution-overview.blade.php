<div class="container px-sm-0">

    <div class="row">
        <div class="col-12 my-4 my-lg-5 pt-4">
            <x-go-back-link
                    href="/{{ app()->getLocale() .'/'. $viewModel->project->slug . '/problems/' . $viewModel->problem->slug }}"
                    class="d-none d-lg-block">{{ __("project-problems.back") }}</x-go-back-link>
        </div>
    </div>
    <div class="row propose-solution-description">

        <div class="col-12">
            <h1 class="section-title text-center">{{ __('solution.share_your_solution') }}</h1>
            <div class="section-body pb-5 pb-lg-0">
                <p>{{ __('solution.do_you_have_an_idea') }}</p>
            </div>
        </div>

    </div>
</div>
<div id="propose-solution-description-container" class="container-fluid no-gutters pt-5">
    <div class="row">
        <div class="container">


            <div class="row propose-solution-description">

                <div class="col-12 col-lg-6">
                    <h2 class="section-title">{{ __("solution.about_the_problem") }}</h2>
                    <div class="section-body pb-5 pb-lg-0">
                        <p>{!! $viewModel->problem->currentTranslation->description !!}</p>
                    </div>
                </div>

                <div class="col-12 col-lg-4 offset-lg-2 align-self-end text-center">
                    <img src="/images/problems/problem-page-intro-top-question@2x.png" alt="Problem intro image"
                         width="382" height="238" class="img-fluid">
                </div>

            </div>

            <div class="row propose-solution-description">
                <div class="col-12 col-lg-2 align-self-end text-center">
                    <img src="/images/solutions/solution-intro.svg" alt="Solution intro image" width="382" height="238"
                         class="img-fluid">
                </div>
                <div class="col-12 col-lg-8 offset-lg-2 align-self-center text-center">
                    <h2 class="section-title">{{ __("solution.solution_get_involved_title") }}</h2>
                    <div class="section-body pb-5 pb-lg-0">
                        <p>{{ __("solution.solution_get_involved_message") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
