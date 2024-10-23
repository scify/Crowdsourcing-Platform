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
            <div class="text-center row">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="px-2">
                                <div class="container-fluid px-lg-5 px-sm-2 py-lg-5 py-sm-3" id="progress-container">
                                    @foreach($badgesVM->badgesWithLevelsList as $badge)
                                        <div class="row progress-for-badge">
                                            <div class="col-md-6 col-sm-12 text-left">
                                                <h6>{{ $badge->badgeName }}</h6>
                                                <p class="mb-1">{{ $badge->badge->progressMessage }}</p>
                                            </div>
                                            <div class="col-md-6 col-sm-12 text-right">
                                                <p class="mb-1">Your level progress: {{ $badge->level }}
                                                    /{{ $badge->badge->finalLevel }}</p>
                                            </div>
                                            <div class="col-12">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: {{ $badge->computeLevelProgressPercentage() }}%"
                                                         aria-valuenow="{{ $badge->computeLevelProgressPercentage() }}"
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 text-left">
                                            <h6>Points</h6>
                                        </div>
                                        <div class="col-md-6 col-sm-12 text-right">
                                            <p class="mb-1">{{$badgesVM->getTotalPoints()}}
                                                / {{$badgesVM->getMaxTotalPoints()}} to unlock a gift!</p>
                                        </div>
                                        <div class="col-12">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: {{ $badgesVM->computeTotalPointsProgressPercentage() }}%"
                                                     aria-valuenow="{{ $badgesVM->computeTotalPointsProgressPercentage() }}"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col mx-auto">
                            <a href="{{ route('my-contributions') }}" class="btn btn-primary btn-lg">{{ __('my-history.my_contributions') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
