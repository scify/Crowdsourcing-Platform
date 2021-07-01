@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/badges.css') }}">
    <link rel="stylesheet" href="{{ mix('dist/css/next-step.css') }}">
@endpush

<div class="card card-danger card-outline">
    <div class="card-header">
        <h3 class="card-title">
            @if ($badgesVM->numOfBadges ==0)
                You don't have any badges, yet!
            @else
                You have <span class="numOfBadges">{{ $badgesVM->numOfBadges }}</span>
                badge{{ $badgesVM->numOfBadges == 1 ? '' : 's' }} so far
                {{--    (<span class="points">{{$badgesVM->totalPoints}}</span> reputation points)--}}
            @endif
        </h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="text-center badges-container row">

                @foreach($badgesVM->badgesWithLevelsList as $badge)
                    <div class="col-md-4 badgeContainer" data-widget="tooltip"
                         title="{{ $badge->statusMessage }}">
                        @include('gamification.badge-single', ['badge' => $badge])
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
