@push('css')
    @vite('resources/assets/sass/gamification/badges.scss')
    @vite('resources/assets/sass/gamification/next-step.scss')
@endpush

<div class="card card-danger card-outline">
    <div class="card-header">
        <h3 class="card-title">
            @if ($badgesVM->numOfBadges ==0)
            {{ __("badges_messages.no_badges_yet") }}  
            @else
                {{-- You have <span class="numOfBadges">{{ $badgesVM->numOfBadges }}</span> badge{{ $badgesVM->numOfBadges == 1 ? '' : 's' }} so far | Click on each badge to view it's description and understand how to gain it --}}
             {!!   trans_choice("badges_messages.you_have_badges", ["count"=>$badgesVM->numOfBadges])  !!}
            @endif
            


                
        </h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="text-center badges-container row">
                @foreach($badgesVM->badgesWithLevelsList as $badge)
                    <div class="col-md-4 badgeContainer"  data-toggle="tooltip"
                         title="{{ $badge->statusMessage }}">
                        @include('gamification.badge-single', ['badge' => $badge])
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
