@extends('layouts.app')
@section('no_search')
@endsection

@section('content')
<div id="app">
	<add-m-ad s_user="{{ Auth::user() }}" csrf="{{ csrf_token() }}"></add-m-ad>
</div>
@endsection