@component('mail::message')
{{-- Greeting --}}
# {{ \App\CPU\Helpers::translate(Hello!', 'mail') }}

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

{{-- Salutation --}}
{{ \App\CPU\Helpers::translate(Regards', 'mail') }},<br>
{{ $settings['website_name'] }}

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
{{ lang("If you're having trouble clicking the button, just copy and paste the URL below into your web browser", "mail") }}
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
