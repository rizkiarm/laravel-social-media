<x-list-groups.list class="mb-5">
  @auth
  <x-list-groups.link icon="house" icontype="solid" routeName="home">Home</x-list-group.link>
  @endauth
  <x-list-groups.link icon="hashtag" icontype="regular" routeName="explore">Explore</x-list-group.link>
  <x-list-groups.link icon="users" icontype="solid" routeName="users.index">Users</x-list-group.link>
  @auth
  <x-list-groups.link icon="bell" icontype="regular" routeName="notifications.index">Notifications</x-list-group.link>
  <x-list-groups.link icon="bookmark" icontype="regular" routeName="posts.bookmarks">Bookmarks</x-list-group.link>
  <x-list-groups.link icon="heart" icontype="regular" routeName="posts.likes">Likes</x-list-group.link>
  @endauth
</x-list-groups.list>