<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <style type="text/css" id="anti-click-jack">body{display:none!important;}</style>
  <script type="text/javascript">
    if(self===top){var acj=document.getElementById("anti-click-jack");acj.parentNode.removeChild(acj)}
    else top.location=self.location;
  </script>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap" />
  <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

  <script>
    var appConfig = {!! json_encode($appConfig) !!};
  </script>

</head>
<body class="font-body font-sans text-sm text-gray-900">

  <div id="app">
    <noscript>
      We're sorry but {{ config('app.name') }} doesn't work properly without JavaScript enabled. Please enable it to continue.
    </noscript>
  </div>

  <script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
