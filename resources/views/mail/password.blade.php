@component('mail::message')

{{ __('We have registered you in the system, login details:') }}

{{ __('Your login') }}: {{ $user->email }}<br>
{{ __('Your password') }}: {{ $password }}

{{ __('Regards') }},<br>
{{ config('app.name') }}

@endcomponent