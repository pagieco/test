<html>
<head>

  <meta charset="UTF-8">
  <title>Page Designer</title>

  <link rel="stylesheet" href="{{ mix('css/frontend.css') }}" class="editor-asset">
  <link rel="stylesheet" href="{{ mix('css/page-editor.css') }}">
  <link rel="stylesheet" href="{{ $project->css_file }}" id="page-css" class="editor-asset">

  <script type="text/json" id="editor/dom/styles">
    {!! $project->css_rules ? json_encode($project->css_rules) : '{}' !!}
  </script>

  <script>
    window.AppConfig = {
      pageId: {{ $page->external_id }},
    };
  </script>

</head>
<body>

  {{-- Render the page --}}
  <div id="page-contents">
    <div>
      <header>
        <h1>header content</h1>
      </header>

      <aside>sidebar content</aside>

      <main>
        <div>
          <h2>Page title</h2>
          <p>
            Lorem ipsum dolor sit amet, <strong>consectetur adipisicing elit</strong>. Amet, deleniti dolores earum est et ipsa laborum
            maiores nam non numquam officia quaerat quod, sapiente, sint ut. Culpa natus nesciunt quibusdam?
          </p>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus asperiores aspernatur at, beatae commodi
            deleniti dolor ducimus eum ex excepturi fugiat illo impedit libero molestiae mollitia neque nisi nobis
            officiis quia quibusdam soluta tenetur veritatis vitae? Eligendi esse eum ex necessitatibus obcaecati
            reiciendis ullam voluptate! Adipisci aperiam autem debitis, dolorem fugiat iste iure labore odit officia
            pariatur, perferendis provident quia quis rem repudiandae temporibus tenetur veniam, vitae. Asperiores, aut
            deserunt, dolorem harum ipsum itaque neque nulla odit omnis placeat ratione recusandae repellat repellendus
            reprehenderit unde. Adipisci blanditiis corporis culpa dignissimos fugit quibusdam voluptas voluptate! Debitis
            illum nesciunt nisi reprehenderit voluptates.
          </p>
        </div>

        <div>
          <h3>Mid section title</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aliquid, autem, corporis distinctio et eum,
            explicabo incidunt inventore libero magnam nemo non odio omnis pariatur perferendis provident qui quod
            repellat tempora vitae. Ad consectetur cumque debitis eaque quaerat. Aliquid blanditiis commodi culpa dolore
            doloribus, ducimus ea enim et expedita fugiat id illo itaque, laudantium officiis perferendis quia repellat
            sapiente tempore vel vero. Accusantium architecto error excepturi magnam optio rerum sed sint tenetur vero
            voluptate. Accusamus doloribus eius enim facere fuga id, nihil non omnis quae saepe. Animi delectus ea esse
            facilis natus sunt! Aliquam at aut cum doloremque doloribus dolorum error eum, exercitationem facere facilis
            fuga fugiat fugit hic id iusto libero modi molestiae nam neque nulla, odio placeat possimus praesentium
            quaerat quas quasi quibusdam, sapiente sed totam voluptate. Aliquam, aut autem beatae consectetur delectus
            deleniti ducimus earum eligendi ex incidunt ipsam itaque nisi optio quia reiciendis repellendus sed ullam.
          </p>

          <hr>

          <img src="http://placehold.it/100x100" />
        </div>
      </main>
    </div>
  </div>

  {{-- Mount for the vue instance --}}
  <div id="app"></div>

  {{-- Mount for the local Vue instance --}}
  <div id="local-app" class="skip-collection"></div>

  {{-- The canvas iframe where the page will be rendered in... --}}
  <iframe id="canvas-frame" frameborder="0"></iframe>

  {{-- The loading overlay --}}
  <div id="loading-overlay">loading...</div>

  <script src="{{ mix('js/frontend.js') }}" class="editor-asset"></script>
  <script src="{{ mix('js/page-editor.js') }}"></script>

</body>
</html>
