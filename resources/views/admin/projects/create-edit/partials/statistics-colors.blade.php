<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <crowd-sourcing-project-colors
                                    :project-id="{{ $viewModel->project->id }}"
                                    :color-data='@json( $viewModel->project->colors)'
                            ></crowd-sourcing-project-colors>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
