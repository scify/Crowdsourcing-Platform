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
        @include('landingpages.partials.share-questionnaire-on-social', ["viewModel"=>$viewModel])


    </div>
</div>


