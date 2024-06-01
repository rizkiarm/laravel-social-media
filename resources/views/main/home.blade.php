<x-app.template>
	<x-slot:title>Home</x-slot>
	<x-slot:sidebar>
		<h5>Popular Users</h5>
		<x-cards.user-list :users="$users" :showFollowStatus="false" />
	</x-slot>
	<x-forms.write-post />
	<br>
	<x-cards.post-list :posts="$posts" />
</x-app.template>