@push('css')
    @vite('resources/assets/sass/gamification/badges.scss')
    @vite('resources/assets/sass/gamification/next-step.scss')
@endpush

<div class="card card-success card-outline">
    <div class="card-body pt-5 px-0">
        <div class="container-fluid px-0">
            <div class="row mb-3">
                <div class="col-md-12 badges-header">
                    <div class="text-center">
                        <h2>{{ __("badges_messages.badges_title") }}</h2>
                        <h4>
                            @if ($badgesVM->numOfBadges ==0)
                                {{ __("badges_messages.no_badges_yet") }}
                            @else
                                {!!   trans_choice("badges_messages.you_have_badges", ["count"=>$badgesVM->numOfBadges])  !!}
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
            <div class="text-center badges-container row">
                @foreach($badgesVM->badgesWithLevelsList as $badge)
                    <div class="col-md-4 badgeContainer px-3" data-toggle="tooltip"
                         title="{!! $badge->statusMessage . $badge->messageForLevel!!}">
                        @include('gamification.badge-single', ['badge' => $badge])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
