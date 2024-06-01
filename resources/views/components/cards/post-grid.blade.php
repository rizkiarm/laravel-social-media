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
<div class="row row-cols-1 row-cols-md-2 g-4">
	@forelse($posts as $post)
		<div class="col">
			<x-cards.post :post="$post" :showText="$showText" :showView="$showView" :showLike="$showLike" :showLikeUsers="$showLikeUsers" :showBookmark="$showBookmark" :showComments="$showComments" :showCommentPosts="$showCommentPosts">
				{{ $post->text }}
			</x-cards.post>
		</div>
	@empty
		<div class="blankslate">
		  <div class="blankslate-body">
		    <h4>No posts</h4>
		  </div>
		</div>
	@endforelse
</div>
<div class="mt-5">
  {{ $posts->links() }}
</div>