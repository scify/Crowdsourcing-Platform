<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

            @if (!$viewModel->isEditMode())
                Please <b>save the problem first </b> to start translating.
            @else
{{--
                <translations-manager
                    :model-meta-data='@json( $viewModel->translationsMetaData)'
                    :existing-translations=' @json( $viewModel->translations)'
                    :default-lang-id="{{ $viewModel->project->language_id }}">
                </translations-manager>
--}}

                translations component

            @endif

            </div>
        </div>
    </div>
</div>
