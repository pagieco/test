<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <!-- This site was created with {{ config('app.name') }}. {{ config('app.url') }} -->
  <!-- Last Published: {{ now() }} -->

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <meta name="generator" content="https://pagie.co" />

</head>
<body>

  @isset($profile)
  <pre>profile: {{ $profile->profile_id }}</pre>
  @endif

    <a href="/test">Test page</a>
    <a href="/">Homepage</a>

  {!! $resource->dom !!}

</body>
</html>
