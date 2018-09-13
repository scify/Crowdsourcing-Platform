@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/badges.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/next-step.css') }}">
@endpush

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">
            @if ($badgesVM->numOfBadges ==0)
                You don't have any badges, yet!
            @else
                You have <span class="numOfBadges">{{ $badgesVM->numOfBadges }}</span>
                badge{{ $badgesVM->numOfBadges == 1 ? '' : 's' }} so far
                {{--    (<span class="points">{{$badgesVM->totalPoints}}</span> reputation points)--}}
            @endif
        </h3>
    </div>
    <div class="box-body">
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