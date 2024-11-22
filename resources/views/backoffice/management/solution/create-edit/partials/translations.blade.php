<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                @if (!$viewModel->isEditMode())
                    Please <b>save the solution first </b> to start translating.
                @else
                    <translations-manager
                            :model-meta-data='@json( $viewModel->translationsMetaData)'
                            :existing-translations=' @json( $viewModel->translations)'
                            :default-lang-id="{{ $viewModel->problem->default_language_id }}">
                    </translations-manager>
                @endif
            </div>
        </div>
    </div>
</div>
