<div class="col-md-12 gamification-badge {{ $badge->level == 0 ? 'locked' : 'unlocked' }}" style="background-color: {{ $badge->color }}">
    <div class="col-md-12 badgeImg">
        <img class="badgeImg" src="{{asset("images/badges/" . $badge->badgeImageName)}}">
    </div>
    <div class="col-md-12">
        <h4 class="align-middle badgeName">{{ $badge->badgeName }}</h4>
        @if($badge->level)
            <h6 class="align-middle badgeLevel">Level: <span
                        class="points">{{ $badge->level }}</span></h6>
            <h5 class="align-middle badgeMessage">{{ $badge->badgeMessage }}</h5>
        @endif
    </div>
</div>