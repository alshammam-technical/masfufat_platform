@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => url('/')])
{{ $settings['website_name'] }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ $settings['website_name'] }}. {{ \App\CPU\Helpers::translate(All rights reserved') }}.
@endcomponent
@endslot
@endcomponent