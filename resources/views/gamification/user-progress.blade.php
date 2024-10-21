@push('css')
    @vite('resources/assets/sass/gamification/progress.scss')
@endpush

<div class="card card-success card-outline">
    <div class="card-body pt-5 px-0">
        <div class="container-fluid px-0">
            <div class="row mb-3">
                <div class="col-md-12 badges-header">
                    <div class="text-center">
                        <h2>{{ __('my-dashboard.your_progress_title') }}</h2>
                        <h4 class="progress-description">{{ __('my-dashboard.your_progress_description') }}</h4>
                    </div>
                </div>
            </div>
            <div class="text-center badges-container row">
            </div>
        </div>
    </div>
</div>
