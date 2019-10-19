<html>
<head>

  <meta charset="UTF-8">
  <title>Page Designer</title>

  <link rel="stylesheet" href="{{ mix('css/frontend.css') }}" class="editor-asset">
  <link rel="stylesheet" href="{{ mix('css/page-editor.css') }}">

</head>
<body>

  <div id="page-contents">
    {!! $page->dom !!}
  </div>

  <div id="editor-wrapper"></div>

  <script src="{{ mix('js/frontend.js') }}"></script>
  <script src="{{ mix('js/page-editor.js') }}"></script>

</body>
</html>
