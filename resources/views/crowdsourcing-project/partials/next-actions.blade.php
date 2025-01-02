<div id="questionnaire-wrapper" class="py-5">
    <div class="container">
        <div id="questionnaire"
             class="align-items-center mx-0"
             style="background-image: url('{{ asset($viewModel->project->lp_questionnaire_img_path) }}')">
            @include('crowdsourcing-project.partials.questionnaire-problems-buttons')
        </div>
    </div>
</div>
