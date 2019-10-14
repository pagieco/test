<h1>Hello {{ $profile->first_name }},</h1>

<p>Please confirm your subscription:</p>

<a href="{!! URL::temporarySignedRoute('confirm-profile-consent', now()->addDays(30), $profile->external_id) !!}">
  {!! URL::temporarySignedRoute('confirm-profile-consent', now()->addDays(30), $profile->external_id) !!}
</a>
