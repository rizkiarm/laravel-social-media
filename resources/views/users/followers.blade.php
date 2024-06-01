@extends('users.template')

@section('content')
<x-cards.user-list :users="$users" :canApprove="true" />
@endsection