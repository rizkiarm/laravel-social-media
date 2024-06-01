@props([
  'user',
  'showFollowButton' => true,
  'showFollowStatus' => true,
  'canApprove' => true,
])

<div {{ $attributes->merge(['class' => 'card']) }}>
  <div class="card-header d-flex align-items-center border-bottom">
    <span class="avatar avatar-lg fs-5">
      <img src="{{ $user->profile->photo }}" />
    </span>
    <div class="ms-3">
      <h6 class="mb-0 fs-sm"><a href="{{ route('users.show', ['user' => $user]) }}">{{ $user->name }}</a></h6>
      <span class="text-muted fs-sm">{{ $user->username }}</span>
    </div>
    @csrf
    @if($showFollowStatus && $user->following)
      <div class="ms-auto">
        @if($user->following == 'pending' && auth()->user()->can('approve', $user) && $canApprove)
          <div class="dropdown dropdown-hover">
            <a class="btn btn-default dropdown-toggle" href="#" role="button">
              {{ $user->following }}
            </a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <form method="POST" action="{{ route('users.approve', ['user' => $user]) }}" class="m-0">
                @csrf
                  <button type="submit" class="dropdown-item">Approve</button>
                </form>
              </li>
              <li>
                <form method="POST" action="{{ route('users.reject', ['user' => $user]) }}" class="m-0">
                  @csrf
                  <button type="submit" class="dropdown-item">Reject</button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <button class="btn btn-primary" disabled>{{ $user->following }}</button>
        @endif
      </div>
    @endif
    @if($showFollowButton)
      <div class="@if($showFollowStatus && $user->following) ms-3 @else ms-auto @endif">
        <form method="POST" action="{{ $user->following ? route('users.unfollow', ['user' => $user]) : route('users.follow', ['user' => $user]) }}" class="m-0">
          @csrf
          @if($user->following)
            {{ method_field('DELETE') }}
          @endif
          <button class="btn btn-subtle text-muted d-flex align-items-center" type="btn">
            <i class="fas fa-user-{{ $user->following ? 'minus' : 'plus' }}" style="padding-right:5px;"></i> 
            <span class="ms-auto">{{ $user->followers()->count() }}</span>
          </button>
        </form>
      </div>
    @endif
  </div>
</div>