<html>
<head>

  <meta charset="UTF-8">
  <title>Workflow Editor</title>

  <link rel="stylesheet" href="{{ mix('css/workflow-editor.css') }}">

  <script>
    window.AppConfig = {
      // ...
    };
  </script>

</head>
<body>

  {{-- Mount for the vue instance --}}
  <div id="app"></div>

  <script src="{{ mix('js/workflow-editor.js') }}"></script>

</body>
</html>
