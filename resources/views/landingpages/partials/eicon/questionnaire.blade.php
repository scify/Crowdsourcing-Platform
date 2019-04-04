<div class="row" id="questionnaire">
    <div class="col-md-12 no-padding">
        @if ($viewModel->questionnaire)
            <div id="questionnaire-wrapper" class="text-center content-container" style="color: #666">
                <h3 class="questionnaire-section-title">{{ $viewModel->userResponse?"You have already participated, thank you!":   $viewModel->questionnaire->title }}</h3>
                @if(!$viewModel->userResponse)
                    <div class="questionnaire-description">
                        What is the potential of ICT for inclusive Pedagogy & Teaching? Our preliminary results are now open for your insights. The consultation process has two parts.
                        <br>
                        <br>
                        <b>1st part</b> - Your expert/practitioner profile: Describe your background and experiences with ICT in practice. (Once you do this, you do not need to fill it in again; next time you contribute can just log in)
                        <br>
                        <br>
                        <b>2nd part</b> - Your voice: See our preliminary results and amend, change or revise the text from your experience. Please do also add your own examples of use of ICT that have been successful in the area of Vocational Education and Training.
                    </div>
                    @include("landingpages.partials.eicon.open-questionnaire-button")
                @endif

            </div>

        @else
            <div id="questionnaire-wrapper" class="text-center content-container ">
                <h3 class="questionnaire-section-title">No active questionnaires<br><br>Our next questionnaire is on its way: stay tuned!</h3>
            </div>
        @endif
    </div>
</div>




@if($viewModel->questionnaire)
    @include('landingpages.modals.questionnaire')
    @include('landingpages.modals.questionnaire-responded')
@endif
