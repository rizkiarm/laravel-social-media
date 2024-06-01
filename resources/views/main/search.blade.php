<x-app.template>
	<x-slot:title>Search results for "{{$keyword}}"</x-slot>
	<x-slot:sidebar>
		<h5>Users</h5>
		<x-cards.user-list :users="$users" :showFollowStatus="false" />
	</x-slot>
	<h5>Posts</h5>
	<x-cards.post-list :posts="$posts" />
</x-app.template>