<x-app.template>
    <x-slot:title>Likes</x-slot>
    <x-cards.post-list :posts="$posts" :showLike="false" :showLikeUsers="false" :showBookmark="false" :showComments="false" />
</x-app.template>