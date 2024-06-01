@props([
  'title' => 'Page',
  'sidebar' => '',
])

<html>
  <head>
    <title>
      {{ $title }} - Z
    </title>
    <x-app.header />
  </head>
  <body>
    <x-app.navbar>{{ $title }}</x-app.navbar>
    <div class="container">
      <div class="row">
          <div class="col-md-3"><x-app.sidebar-left /></div>
          <div class="col-md-6">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="m-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            {{ $slot }}
          </div>
          <div class="col-md-3">
            {{ $sidebar }}
            <x-app.sidebar-right />
          </div>
        </div>
    </div>
    <x-app.scripts />
  </body>
</html>