@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/badge-single.css') }}">
@endpush

<div class="col-md-12 gamification-badge {{ $badge->level == 0 ? 'locked' : 'unlocked' }}"
     style="background-color: {{ $badge->color }};
             font-family: 'Open Sans', sans-serif !important;
             padding: 15px;
             border-radius: 10px;
             color: white; !important">
    <div class="col-md-12 badgeImg">
        <img class="badgeImg" src="{{asset("images/badges/" . $badge->badgeImageName)}}">
    </div>
    <div class="col-md-12 mt-2">
        <h4 class="align-center badgeName" style="color: white; !important">{{ $badge->badgeName }}</h4>
        @if($badge->level)
            <h6 class="align-center badgeLevel" style="color: white; !important">Level: <span
                        class="points" style="font-weight: bold;">{{ $badge->level }}</span></h6>
            <h5 class="align-center badgeMessage" style="color: white; !important">{{ $badge->badgeMessage }}</h5>
        @endif
    </div>
</div>
