@props([
  'notifications',
  'replaceYou' => false
])

<ul {{ $attributes->merge(['class' => 'list-group list-group-flush border']) }}>
  @forelse($notifications as $notification)
    <li class="list-group-item">
      <div>
        @if(is_null($notification->causer))
          [deleted]
        @else
          <a href="{{ route('users.show', ['user' => $notification->causer]) }}">{{ $replaceYou && auth()->user() && $notification->causer->id == auth()->user()->id ? 'You' : $notification->causer->name }}</a> 
        @endif

        {{ $notification->event }} 

        @if($notification->subject_type == 'App\Models\User')
          @if(is_null($notification->subject))
            [deleted user]
          @else
            <a href="{{ route('users.show', ['user' => $notification->subject]) }}">{{ $replaceYou && auth()->user() &&$notification->subject->id == auth()->user()->id ? 'you' : $notification->subject->name }}</a>
          @endif
        @else
          a 
          @if(is_null($notification->subject))
            [deleted post]
          @else
            <a href="{{ route('posts.show', ['post' => $notification->subject]) }}">post</a> by <a href="{{ route('users.show', ['user' => $notification->subject->user]) }}">{{ $notification->subject->user->username }}</a>
          @endif
        @endif
      </div>  
      <span class="small text-muted">
        {{ $notification->created_at->diffForHumans(); }}
      </span>
    </li>
  @empty
    <div class="blankslate">
      <div class="blankslate-body">
        <h4>No notifications</h4>
      </div>
    </div>
  @endforelse
</ul>
<div class="mt-2">
  {{ $notifications->links() }}
</div>