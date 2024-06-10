@push('css')
    @vite('resources/dist/css/badge-single.css')
@endpush

<div class="col-md-12 gamification-badge {{ $badge->level == 0 ? 'locked' : 'unlocked' }}"
     style="background-color: {{ $badge->color }};">
    <div class="col-md-12 badge-img-container">
        <img loading="lazy" class="badgeImg" src="{{asset("images/badges/" . $badge->badgeImageName)}}" alt="badge image">
    </div>
    <div class="col-md-12 mt-2">
        <h4 class="badge-name badge-name-{{ $badge->level == 0 ? 'black' : 'white' }}">{{ $badge->badgeName }}</h4>
        @if($badge->level)
            <h6 class="badge-level">Level: <span
                        class="points">{{ $badge->level }}</span></h6>
            <h5 class="badge-message">{!! $badge->badgeMessage !!}</h5>
        @else
            <h6 class="badge-level badge-level-zero" style="">Level: <span class="points">0</span></h6>
            <h5 class="badge-message badge-message-zero">{{ __("badges_messages.you_do_not_own") }}</h5>
        @endif
    </div>
</div>
