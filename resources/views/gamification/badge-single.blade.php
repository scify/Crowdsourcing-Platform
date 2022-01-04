@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/badge-single.css') }}">
@endpush

<div class="col-md-12 gamification-badge {{ $badge->level == 0 ? 'locked' : 'unlocked' }}"
     style="background-color: {{ $badge->color }};
             font-family: 'Open Sans', sans-serif !important;
             padding: 15px;
             border-radius: 10px;
             color: white; !important">
    <div class="col-md-12 badgeImg" style="text-align: center; margin-bottom: 1rem;">
        <img loading="lazy" class="badgeImg" height="130px" src="{{asset("images/badges/" . $badge->badgeImageName)}}">
    </div>
    <div class="col-md-12 mt-2">
        <h4 class="badgeName" style="color: {{ $badge->level == 0 ? 'black' : 'white' }}; text-align: center; margin: 0.5rem 0;">{{ $badge->badgeName }}</h4>
        @if($badge->level)
            <h6 class="badgeLevel" style="color: white; text-align: center;font-size: 1.3rem; margin: 0.5rem 0 1rem; ">Level: <span
                        class="points" style="font-weight: bold;">{{ $badge->level }}</span></h6>
            <h5 class="badgeMessage" style="color: white;font-size: 1rem; text-align: center; margin: 0.5rem 0;">{!! $badge->badgeMessage !!}</h5>
        @else
            <h6 class="badgeLevel" style="color: black; text-align: center;font-size: 1.3rem; margin: 0.5rem 0 1rem; ">Level: <span class="points" style="font-weight: bold;">0</span></h6>
            <h5 class="badgeMessage" style="color: black; font-size: 1rem; text-align: center; margin: 0.5rem 0;">{{ __("badges_messages.you_do_not_own") }}</h5>
        @endif
    </div>
</div>
