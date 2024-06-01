<x-app.template>
	<x-slot:title>Explore</x-slot>
	<x-slot:sidebar>
		<h5>Popular Users</h5>
		<x-cards.user-list :users="$users" :showFollowStatus="false" />
	</x-slot>
	<x-cards.post-list :posts="$posts" />
</x-app.template>