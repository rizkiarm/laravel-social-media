@extends('users.template')

@section('content')
<x-forms.write-post />
<br>
<x-cards.post-list :posts="$posts" />
@endsection