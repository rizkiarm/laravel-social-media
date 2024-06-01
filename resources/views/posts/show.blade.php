<x-app.template>
    <x-slot:title>Post</x-slot>
    <x-slot:sidebar>
      <h5>Comments</h5>
      @forelse($comments as $comment)
        <x-cards.post :post="$comment" :showView="false" :showLike="false" :showLikeUsers="false" :showBookmark="false" :showComments="false" :showCommentPosts="true">
          {{ $comment->text }}
        </x-cards.post>
      @empty
        <div class="blankslate">
          <div class="blankslate-body">
            <h4>No comments</h4>
          </div>
        </div>
      @endforelse
      <div class="my-2">
        {{ $comments->links() }}
      </div>
      <form action="{{ route('posts.store') }}" method="POST" class="m-0 d-flex">
        @csrf
        <div>
          <input type="hidden" name="parent_id" value="{{ $post->id }}">
          <textarea name="text" class="form-control" placeholder="Insert comment..."></textarea>
        </div>
        <button type="submit" value="Submit" class="btn btn-primary"><i class="fas fa-comment fa-lg"></i> Send</button>
      </form> 
    </x-slot>
    <x-cards.post :post="$post">
        {{ $post->text }}
    </x-cards.post>

</x-app.template>