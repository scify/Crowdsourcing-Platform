<div class="container py-5">

    <div class="goal-title">
        <h2 class="info">
            @if ($viewModel->totalResponses==0)
                {{ __("questionnaire.zero_answers") }}
            @else
                {!! __("questionnaire.answers_so_far", ["total"=>$viewModel->totalResponses]) !!}
            @endif

            @if($viewModel->shareUrlForFacebook || $viewModel->shareUrlForTwitter)
                {{ __("questionnaire.invite_your_friends_to_answer")}}
            @endif
        </h2>
        <div class="col-10 col-md-12 mx-auto d-flex flex-wrap justify-content-center social-share">
            @include('crowdsourcing-project.partials.share-questionnaire-on-social', ["viewModel"=>$viewModel])
        </div>
        @if($viewModel->userCanViewStatistics)
            <div class="mt-5 text-center">
                <a href="{{ route('questionnaire.statistics', ['questionnaire' => $viewModel->questionnaire->id]) }}"
                   class="btn btn-outline-primary"
                   target="_blank">
                    <i class="fas fa-chart-bar mr-1" aria-hidden="true"></i>
                    {{ __("questionnaire.see_results") }}
                </a>
            </div>
        @endif
    </div>
</div>
