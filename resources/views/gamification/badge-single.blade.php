@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/badge-single.css') }}">
@endpush

<div class="col-md-12 gamification-badge {{ $badge->level == 0 ? 'locked' : 'unlocked' }}"
     style="background-color: {{ $badge->color }};
             font-family: 'Open Sans', sans-serif !important;
             padding: 15px;
             border-radius: 10px;
             color: white; !important">
    <div class="col-md-12 badgeImg" style="text-align: center; margin-bottom: 1rem;">
        <img class="badgeImg" height="130px" src="{{asset("images/badges/" . $badge->badgeImageName)}}">
    </div>
    <div class="col-md-12 mt-2">
        <h4 class="badgeName" style="color: white; text-align: center; margin: 0.5rem 0;">{{ $badge->badgeName }}</h4>
        @if($badge->level)
            <h6 class="badgeLevel" style="color: white; text-align: center; margin: 0.5rem 0; ">Level: <span
                        class="points" style="font-weight: bold;">{{ $badge->level }}</span></h6>
            <h5 class="badgeMessage" style="color: white; text-align: center; margin: 0.5rem 0;">{{ $badge->badgeMessage }}</h5>
        @endif
    </div>
</div>
