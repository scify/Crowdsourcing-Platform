<div class="container py-5">

    <div class="goal-title">
        <h2 class="info">
            @if ($viewModel->totalResponses==0)
                {{ __("questionnaire.zero_answers") }}
            @else
               {!! __("questionnaire.answers_so_far", ["total"=>$viewModel->totalResponses]) !!}
            @endif


        </h2>
        @if($viewModel->shareUrlForFacebook || $viewModel->shareUrlForTwitter)
            @push('css')
                <link rel="stylesheet" href="{{ mix('dist/css/social-share.css') }}">
            @endpush
            <div class="social-share text-center">
                <p class="title">{{ __("my-dashboard.share_questionnaire")}}</p>

                @include('questionnaire.social-share-button', [
                      'project_name' => $viewModel->project->currentTranslation->motto_title ,
                      'questionnaire_title' =>  $viewModel->questionnaire->currentFieldsTranslation->title ,
                        'questionnaire_id' =>$viewModel->questionnaire->id,
                       'socialShareURL' => $viewModel->shareUrlForFacebook,
                       'additionalBtnStyleClasses' =>' facebook btn-lg btn-default',
                       'btnText' => '<i class="fab fa-facebook-f"></i> Facebook'
                   ])

                @include('questionnaire.social-share-button', [
                       'project_name' =>$viewModel->project->currentTranslation->motto_title ,
                       'questionnaire_title' => $viewModel->questionnaire->currentFieldsTranslation->title,
                        'questionnaire_id' =>$viewModel->questionnaire->id,
                       'socialShareURL' => $viewModel->shareUrlForTwitter,
                       'additionalBtnStyleClasses' =>' twitter btn-lg btn-default',
                       'btnText' => '<i class="fab fa-twitter"></i> Twitter'
                   ])

            </div>
        @endif

    </div>

    <div class="row activity-container wrapper-box py-4 bg-white">
        <div class="col-md-12 col-sm-12 text-center" >
            @if ($viewModel->totalResponses ==0)
                <p class="no-activity-found-msg"
                   style="color: var(--project-primary-color);">
                    {{ __("questionnaire.no_recent_activity") }}
                </p>
            @elseif ($viewModel->totalResponses > 0)
                <div class="activity-title  pb-2 wrapper-title">
                    <p style="color: var(--project-primary-color);">{{ __("questionnaire.latest_contributors") }}</p>
                </div>
                <div class="activity-content">
                    @foreach($viewModel->allResponses as $response)
                        @if($response->user_name)
                            <div class="activity-item text-left">
                                <i style="color: var(--project-primary-color);"
                                   class="fa fa-user-circle user-icon" aria-hidden="true"></i>
                                @if($response->created_at)
                                  {!! __("questionnaire.name_and_date_of_last_contributors", [ "name"=>"<b> $response->user_name </b>", "date" => \Carbon\Carbon::parse($response->created_at)->format('F d, Y')])!!}
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

        </div>


    </div>
</div>


