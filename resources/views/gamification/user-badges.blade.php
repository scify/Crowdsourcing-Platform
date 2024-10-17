@push('css')
    @vite('resources/assets/sass/gamification/badges.scss')
    @vite('resources/assets/sass/gamification/next-step.scss')
@endpush

<div class="card card-success card-outline">
    <div class="card-body pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 badges-header">
                    <div class="text-center">
                        <h2>{{ __("badges_messages.badges_title") }}</h2>
                        <p>
                            @if ($badgesVM->numOfBadges ==0)
                                {{ __("badges_messages.no_badges_yet") }}
                            @else
                                {!!   trans_choice("badges_messages.you_have_badges", ["count"=>$badgesVM->numOfBadges])  !!}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="text-center badges-container row">
                @foreach($badgesVM->badgesWithLevelsList as $badge)
                    <div class="col-md-4 badgeContainer" data-toggle="tooltip"
                         title="{{ $badge->statusMessage }}">
                        @include('gamification.badge-single', ['badge' => $badge])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
