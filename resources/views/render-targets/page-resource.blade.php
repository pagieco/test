<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <!-- This site was created with {{ config('app.name') }}. {{ config('app.url') }} -->
  <!-- Last Published: {{ now() }} -->

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <meta name="generator" content="https://pagie.co" />

  @if ($domain->google_site_verification_id)
  <meta name="google-site-verification" content="{{ $domain->google_site_verification_id }}" />
  @endif

  @if ($domain->gtm)
  {{-- Google Tag Manager --}}
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','{{ $domain->gtm }}');</script>
  {{-- End Google Tag Manager --}}
  @endif

  @if ($domain->facebook_pixel_id)
  {{-- Facebook Pixel Code --}}
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $domain->facebook_pixel_id }}');
    fbq('track', 'PageView');
  </script>

  <noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $domain->facebook_pixel_id }}&ev=PageView&noscript=1" />
  </noscript>
  {{-- End Facebook Pixel Code --}}
  @endif

</head>
<body>

  @if ($domain->gtm)
  {{-- Google Tag Manager (noscript) --}}
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id={{ $domain->gtm }}" height="0" width="0" style="display:none;visibility:hidden"></iframe>
  </noscript>
  {{-- End Google Tag Manager (noscript) --}}
  @endif

  @isset($profile)
  <pre>profile: {{ $profile->profile_id }}</pre>
  @endif

  <a href="/test">Test page</a>
  <a href="/">Homepage</a>

  {!! $resource->dom !!}

</body>
</html>
