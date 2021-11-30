<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (!$viewModel->isEditMode())
                    Please <b>save the project first </b> to start translating.
                @else
                    <translations-manager
                            :model-meta-data='@json( $viewModel->translationsMetaData)'
                            :existing-translations=' @json( $viewModel->translations)'></translations-manager>
                @endif
            </div>
        </div>
    </div>
</div>
