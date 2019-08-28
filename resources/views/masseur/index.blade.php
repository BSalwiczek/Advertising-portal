@extends('layouts.app')
@section('no_search')
@endsection

@section('content')
	<masseur-profile s_user="{{ Auth::user() }}" csrf="{{  csrf_token() }}"></masseur-profile>
@endsection