@component('mail::message')
# {{ $details['title'] }}

{{  $details['body'] }}
@component('mail::button', ['url' => $details['url'], 'color' => 'success'])
Connectez vous!!
@endcomponent

@lang('Merci'),<br>
{{ config('app.name') }}
@endcomponent
