@props([
  'post',
  'showText' => true,
  'showView' => false,
  'showLike' => true,
  'showLikeUsers' => true,
  'showBookmark' => true,
  'showComments' => true,
  'showCommentPosts' => false,
])

<div {{ $attributes->merge(['class' => 'card']) }}>
  <div class="card-header d-flex align-items-center pb-0">
    <span class="avatar avatar-lg fs-5">
      <img src="{{ $post->user->profile->photo }}" />
    </span>
    <div class="ms-3">
      <h6 class="mb-0 fs-sm"><a href="{{ route('users.show', ['user' => $post->user]) }}">{{ $post->user->name }}</a></h6>
      <span class="text-muted fs-sm">{{ $post->created_at->diffForHumans(); }}</span>
    </div>
    @can('delete', $post)
      <div class="dropstart ms-auto">
        <button class="btn text-muted" type="btn" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu">
          <li>
            <form method="POST" action="{{ route('posts.destroy', ['post' => $post]) }}" class="m-0">
              @csrf
              {{ method_field('DELETE') }}
              <button type="submit" class="dropdown-item">Delete</button>
            </form>
          </li>
        </ul>
      </div>
    @endcan
  </div>
  @if($showText)
    <div class="card-body">
      <p class="card-text">
          {{ $slot }}
      </p>
    </div>
  @else
  <div class="mb-3"></div>
  @endif
  @php
    $media_urls = array_map(function($media){ return url('storage', $media['path']); }, $post->medias->toArray());
  @endphp
  @if(count($media_urls) > 0)
    <x-carousel :images="$media_urls"></x-carousel>
  @endif
  @if($showView || $showLikeUsers || $showLike || $showLike || $showBookmark || $showComments)
    <div class="card-footer d-flex">
      @if($showView)
      <a class="btn btn-link p-0 me-auto fw-bold align-content-center" href="{{ route('posts.show', ['post' => $post]) }}">View</a>
      @else
      <span class="me-auto"></span>
      @endif

      @if($showLikeUsers)
        @php
          $collapseId = "collapsePost".$post->id."LikedByUsers";
        @endphp
        <button class="avatar-stack btn btn-subtle p-0" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">
          @php 
            $maxRandom = min(count($post->likedByUsers), 3);
            $likesLeft = max(count($post->likedByUsers) - 3,0);
          @endphp
          @if($likesLeft > 0)
            <span class="avatar">+{{ $likesLeft }}</span>
          @endif
          @foreach($post->likedByUsers->random($maxRandom) as $user)
            <img class="avatar" src="{{ url($user->profile->photo) }}" />
          @endforeach
        </button>
      @endif
      @if($showLike)
        @if($post->liked)
        <form method="POST" action="{{ route('posts.unlike', ['post' => $post]) }}" class="m-0">
            @csrf
            {{ method_field('DELETE') }}
            <button class="btn btn-subtle" type="submit"><i class="fas fa-heart fa-lg"></i> {{ count($post->likes) }}</button>
        </form>
        @else
        <form method="POST" action="{{ route('posts.like', ['post' => $post]) }}" class="m-0">
            @csrf
            <button class="btn btn-subtle" type="submit"><i class="far fa-heart fa-lg"></i> {{ count($post->likes) }}</button>
        </form>
        @endif
      @endif

      @if($showBookmark)
        @if($post->bookmarked)
        <form method="POST" action="{{ route('posts.unbookmark', ['post' => $post]) }}" class="m-0">
            @csrf
            {{ method_field('DELETE') }}
            <button class="btn btn-subtle" type="submit"><i class="fas fa-bookmark fa-lg"></i> {{ count($post->bookmarks) }}</button>
        </form>
        @else
        <form method="POST" action="{{ route('posts.bookmark', ['post' => $post]) }}" class="m-0">
            @csrf
            <button class="btn btn-subtle" type="submit"><i class="far fa-bookmark fa-lg"></i> {{ count($post->bookmarks) }}</button>
        </form>
        @endif
      @endif

      @if($showComments)
      <a class="btn btn-subtle" href="{{ route('posts.show', ['post' => $post]) }}"><i class="far fa-comment fa-lg"></i> {{ count($post->comments) }}</a>
      @endif

    </div>
  @endif

  @if($showLikeUsers)
  <div class="collapse m-0" id="{{ $collapseId }}">
    <div class="card-body pt-0">
      <x-cards.user-list :users="$post->likedByUsers" />
    </div>
  </div>
  @endif

  @if($showCommentPosts)
    <div class="card-footer m-0 py-0 bg-light" style="padding-right: 0px;">
      @foreach($post->comments as $comment)
        <x-cards.post :post="$comment" :showView="false" :showLike="false" :showLikeUsers="false" :showBookmark="false" :showComments="false" :showCommentPosts="false">
          {{ $comment->text }}
        </x-cards.post>
      @endforeach

      <form action="{{ route('posts.store') }}" method="POST" class="m-0 d-flex">
          @csrf
          <div>
              <input type="hidden" name="parent_id" value="{{ $post->id }}">
              <textarea name="text" class="form-control" placeholder="Insert comment..."></textarea>
          </div>
          <button type="submit" value="Submit" class="btn btn-primary"><i class="fas fa-comment fa-lg"></i> Send</button>
      </form> 
    </div>
  @endif
</div>