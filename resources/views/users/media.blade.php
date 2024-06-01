@extends('users.template')

@section('content')
<x-cards.post-grid :posts="$posts" :showText=false :showLikeUsers=false />
@endsection