@push('css')
    @vite('resources/assets/sass/gamification/badge-single.scss')
@endpush

<div class="container-fluid gamification-badge {{ $badge->level == 0 ? 'locked' : 'unlocked' }}"
     style="background-color: {{ $badge->color }};">
    <div class="row">
        @if(isset($title))
            <div class="col-md-12">
                <h3 class="badge-title">{{ $title }}</h3>
            </div>
        @endif
        <div class="col-md-12 badge-img-container">
            <img loading="lazy" class="badgeImg" src="{{asset("images/badges/" . $badge->badgeImageName)}}"
                 alt="Badge" style="height: 200px;">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-2">
            <h4 class="badge-name badge-name-{{ $badge->level == 0 ? 'black' : 'white' }}">{{ $badge->badgeName }}</h4>
            <p class="my-0 badge-level badge-level-{{ $badge->level == 0 ? 'black' : 'white' }}">Level: <span
                        class="points">{{ $badge->level }}</span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-2 badge-message-container badge-message-container-{{ $badge->level == 0 ? 'black' : 'white' }}">
            <p class="badge-message badge-message-{{ $badge->level == 0 ? 'black' : 'white' }}">{!! $badge->badgeMessage !!}</p>
        </div>
    </div>
</div>
