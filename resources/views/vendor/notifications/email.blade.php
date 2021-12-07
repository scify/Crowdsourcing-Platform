@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Hello!
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{!! $line !!}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{!! $line !!}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{!! $salutation !!}
@else
{{ __("email_messages.regards")}},<br><br>The Crowdsourcing Team
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
{{ __("email_messages.trouble_with_button")}} "{{ $actionText }}" {{ __("email_messages.copy_paste_url")}} [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
