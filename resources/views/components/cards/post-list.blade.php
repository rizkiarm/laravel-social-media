@props([
  'posts',
  'showText' => true,
  'showView' => true,
  'showLike' => true,
  'showLikeUsers' => true,
  'showBookmark' => true,
  'showComments' => true,
  'showCommentPosts' => false,
])

@forelse($posts as $post)
	<x-cards.post :post="$post" :showText="$showText" :showView="$showView" :showLike="$showLike" :showLikeUsers="$showLikeUsers" :showBookmark="$showBookmark" :showComments="$showComments" :showCommentPosts="$showCommentPosts">
		{{ $post->text }}
	</x-cards.post>
	<br>
@empty
	<div class="blankslate">
	  <div class="blankslate-body">
	    <h4>No posts</h4>
	  </div>
	</div>
@endforelse
<div class="mt-0">
  {{ $posts->links() }}
</div>