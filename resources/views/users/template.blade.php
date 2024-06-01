<x-app.template>
  <x-slot:title>{{ $user->name }}</x-slot>

  <x-slot:sidebar>
    @if(!$user->protected)
      <h5>Recent Activities</h5>
      <x-list-groups.notifications :notifications="$notifications" :replaceYou=false />
    @endif
  </x-slot:sidebar>

  <div class="card">
    <div class="row g-0">
      <div class="col-md-4">
        <div class="card-body">
          <img src="{{ url($user->profile->photo) }}" class="img-fluid rounded">
        </div>
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title d-flex">
            <div class="ms-0">
              {{ $user->name }}<br><class class="small text-muted">{{ $user->username }}</span>
            </div>
            <span class="ms-auto"></span>
            @if($user->following)
            <button class="btn btn-primary" disabled>{{ $user->following }}</button>
            @endif
            <div class="d-flex align-items-center">
              <form method="POST" action="{{ $user->following ? route('users.unfollow', ['user' => $user]) : route('users.follow', ['user' => $user]) }}" class="m-0">
                @if($user->following)
                  {{ method_field('DELETE') }}
                @endif
                @csrf
                <button class="btn btn-subtle" type="btn"><i class="fas fa-user-{{ $user->following ? 'minus' : 'plus' }}"></i></button>
              </form>
            </div>
            @can('update', $user)
              <div class="d-flex align-items-center">
                <a class="btn btn-subtle" href="{{ route('users.edit', ['user' => $user]) }}"><i class="fas fa-edit"></i></a>
              </div>
            @endcan
          </h5>
          @if(!$user->protected)
          <p class="card-text">
            {{ $user->profile->description }}
          </p>
          @endif
        </div>
      </div>
    </div>
    @if(!$user->protected)
    <div class="card-body pt-0">
      <div class="row g-0 text-center">
        <div class="col-md-3">
          <i class="fa-regular fa-envelope"></i>  {{ $user->email }}
        </div>
        <div class="col-md-3">
          @if($user->profile->gender == 'male')
            <i class="fa-solid fa-mars"></i>
          @else
            <i class="fa-solid fa-venus"></i>
          @endif 
          {{ $user->profile->gender }}
        </div>
        <div class="col-md-3">
          <i class="fa-solid fa-cake-candles"></i> {{ $user->profile->birthdate }}
        </div>
        <div class="col-md-3">
          <i class="fa-solid fa-location-dot"></i> {{ $user->profile->location }}
        </div>
      </div>
    </div>
    @endif
  </div>

  @if($user->protected)
    <div class="blankslate">
      <h1 class="blankslate-top">
        <i class="fa-solid fa-lock"></i>
      </h1>
      <div class="blankslate-body">
        <h4>This user is protected</h4>
        <p>
          This user needs to accept your follow request for you to view the profile.
        </p>
      </div>
    </div>
  @else
    <ul class="nav nav-fill nav-tabs m-5 mx-0" role="tablist">
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users.show') ? 'active' : ''}}" href="{{ route('users.show', ['user' => $user]) }}">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users.media') ? 'active' : ''}}" href="{{ route('users.media', ['user' => $user]) }}">Media</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users.followings') ? 'active' : ''}}" href="{{ route('users.followings', ['user' => $user]) }}">Followings</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users.followers') ? 'active' : ''}}" href="{{ route('users.followers', ['user' => $user]) }}">Followers</a>
      </li>
    </ul>

    <div class="tab-content pt-0">
      <div class="tab-pane active">
        @yield('content')
      </div>
    </div>
  @endif
</x-app.template>