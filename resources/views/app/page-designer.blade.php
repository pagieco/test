<html>
<head>

  <meta charset="UTF-8">
  <title>Page Designer</title>

  <link rel="stylesheet" href="{{ mix('css/frontend.css') }}" class="editor-asset">
  <link rel="stylesheet" href="{{ mix('css/page-editor.css') }}">
  <link rel="stylesheet" href="{{ $project->css_file }}" id="page-css" class="editor-asset">

  <script type="text/json" id="editor/dom/styles">
    {!! $project->css_rules ? $project->css_rules : '{}' !!}
  </script>

</head>
<body>

  {{-- Render the page --}}
  <div id="page-contents">
    {!! $page->dom !!}
  </div>

  {{-- Mount for the vue instance --}}
  <div id="app"></div>

  {{-- Mount for the local Vue instance --}}
  <div id="local-app"></div>

  {{-- The canvas iframe where the page will be rendered in... --}}
  <iframe id="canvas-frame" frameborder="0"></iframe>

  {{-- The loading overlay --}}
  <div id="loading-overlay">loading...</div>

  <script src="{{ mix('js/frontend.js') }}" class="editor-asset"></script>
  <script src="{{ mix('js/page-editor.js') }}"></script>

</body>
</html>
