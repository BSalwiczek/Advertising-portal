@extends('layouts.app')
@section('no_search')
@endsection

@section('content')
	<masseur-profile s_friend_data="{{ $friend_data }}" s_user="{{ Auth::user() }}" csrf="{{  csrf_token() }}" :first-option="{{ $option }}" :message-friend-id="{{ $friend_id }}"></masseur-profile>
@endsection
