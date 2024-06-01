@props([
  'users',
  'showFollowButton' => true,
  'showFollowStatus' => true,
  'canApprove' => true,
])

@forelse($users as $user)
	<x-cards.user :user="$user" :showFollowButton="$showFollowButton" :showFollowStatus="$showFollowStatus" :canApprove="$canApprove" class="mb-2"/>
@empty
	<div class="blankslate">
	  <div class="blankslate-body">
	    <h4>No users</h4>
	  </div>
	</div>
@endforelse
@if($users instanceof \Illuminate\Pagination\AbstractPaginator)
<div class="mt-0">
  {{ $users->links() }}
</div>
@endif