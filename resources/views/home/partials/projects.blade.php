<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ __('common.crowd_sourcing_campaigns') }}</h2>
            <div class="content-container container-fluid">
                <div class="row">
                    <div class="col-lg-9 col-md-11 col-sm-11 mx-auto">
                        <p>
                            {{ __('common.crowd_sourcing_campaigns_description') }}
                        </p>
                    </div>
                </div>
                @include('home.partials.projects-list-home')
            </div>
        </div>
    </div>
</div>
