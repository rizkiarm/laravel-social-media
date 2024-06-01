<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      <!-- <img src="{{ url('storage', 'logo.svg') }}" width="36" alt="Z" /> -->
      <i class="fa-solid fa-bolt text-primary"></i>
    </a>
    <ul class="navbar-nav">
      <li class="nav-item">
        {{ $slot }}
      </li>
    </ul>

    <!-- Toggler button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="navbar-nav ms-auto">
        <form class="me-2 mb-2 mb-lg-0 input-group" action="{{ route('search.post') }}" method="POST">
          {{csrf_field()}}
          <input type="text" name='keyword' class="form-control form-control-sm" placeholder="Search" value="{{ app('request')->keyword }}" />
          <button class="btn btn-default"><i class="fas fa-search"></i></button>
        </form>
      </div>
      <div class="navbar-nav d-flex align-items-center">
        @guest
        <a class="btn btn-default px-3 me-2" href="{{ route('login') }}">
          Login
        </a>
        <a class="btn btn-primary me-3" href="{{ route('register.create') }}">
          Sign Up
        </a>
        @endguest
      </div>
      @auth
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          @if(auth()->user()->profile && auth()->user()->profile->photo)
          <a class="avatar" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ auth()->user()->profile->photo }}" />
          </a>
          @else
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ auth()->user()->name }}
          </a>
          @endif
          <ul class="dropdown-menu">
            <li>
              <a href="{{ route('users.show', ['user' => auth()->user()]) }}" class="dropdown-item">Profile</a>
              <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button class="dropdown-item" type="submit">Logout</button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
      @endauth
    </div>
  </div>
</nav>
<div class="p-10"></div>