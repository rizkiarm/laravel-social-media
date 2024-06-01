<x-app.template>
    <x-slot:title>Bookmarks</x-slot>
    <x-cards.post-grid :posts="$posts" :showLike="false" :showLikeUsers="false" :showBookmark="false" :showComments="false" class="mb-5" />
</x-app.template>