@extends('layouts.app')

@section('title',$post->title)

@section('tree1')
	<a href="/masazysci">Ogłoszenia masażystów</a>
@endsection

@section('tree2',$post->title)

@section('content')
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<div class="container mx-auto" style="padding:2rem 0;min-width:80%;margin:0">
	<div class="row">
		<div class="col-sm-3">
			<div class="box-container">
				<div class="row">
					<div class="col-md-6 offset-md-3">
						<img src="/storage/avatars/{{ $post->user->profile_img }}" class="avatar rounded-circle img-fluid 	mx-auto">
					</div>
				</div>
			@if($notesCount==0)
				<div class="text-center mt-3">
					<h5>Brak opinii</h5>
				</div>
			@else
				<passive-stars class="text-center" :stars="{{$averageNote}}"></passive-stars>
				<div class="text-center">
					<h5>{{ $averageNote }}/5 ({{ $notesCount }} głosów)</h5>
				</div>
			@endif



				<h3 class="text-center mt-3">{{ $post->user->name }} {{ $post->user->surname }}</h3>
				<contact-button :user-id="{{ $post->user->id }}" csrf={{ csrf_token() }}></contact-button>
			</div>



		{{-- {{ $post->user->name }}
		{{ $post->created_at }} --}}
		</div>
		<div class="col-sm-9 ad-description">

			<div class="text-center box-container px-5 pt-4">
				<div class="text-right mb-4">
					<i class="far fa-clock" style="margin-right: 1%;color:#09A2E5"></i> {{ $post->created_at }}
				</div>
				<h1>{{ $post->title }}</h1>
				<div class="mx-auto" style="width: 30%">
					<hr>
				</div>
				<p class="mt-4">{{ $post->description }}</p>
			</div>

			<div class="box-container mt-3">
				<div class="text-center">
					<h3>Gdzie zrealizuję masaż?</h3>
					<div class="mx-auto" style="width: 30%">
						<hr>
					</div>
				</div>

				@if($post->area !== null && $post->city !== null)
				<div class="row">
					<div class="col-sm-6">
						<div class="text-center mt-4">
							<h5 style="color:#53C5F7;">Dojazd do klienta</h5>

							<div class="mx-auto" style="width: 15%">
								<hr style="border-color: #53C5F7; margin-top:0;margin-bottom: 0.5rem">
							</div>
							{{ $post->area }}
						</div>
					</div>
					<div class="col-sm-6">
						<div class="text-center mt-4">
							<h5 style="color:#53C5F7;">U masażysty</h5>
							<div class="mx-auto" style="width: 15%">
								<hr style="border-color: #53C5F7; margin-top:0;margin-bottom: 0.5rem">
							</div>
							{{ $post->city }}, woj. {{ $post->province }}<br>
							ul. {{ $post->street }}
							{{ $post->number }}
						</div>
					</div>
				</div>

				@elseif($post->area !== null)
				<div class="mx-auto text-center mt-4">
					<h5 style="color:#53C5F7;">Dojeżdżam do klienta</h5>
					<div class="mx-auto" style="width: 15%">
						<hr style="border-color: #53C5F7; margin-top:0;margin-bottom: 0.5rem">
					</div>
					{{ $post->area }}
				</div>
				@else
				<div class="mx-auto text-center mt-4">
					<h5 style="color:#53C5F7;">U mnie</h5>
					<div class="mx-auto" style="width: 15%">
						<hr style="border-color: #53C5F7; margin-top:0;margin-bottom: 0.5rem">
					</div>
					{{ $post->city }} woj. {{ $post->province }}<br>
					ul.{{ $post->street }}
					{{ $post->number }}
				</div>
				@endif


			</div>

			<div class="box-container mt-3 text-center">
				<div class="text-center">
					<h3>Oferowane rodzaje masażu</h3>
					<div class="mx-auto mb-5" style="width: 30%">
						<hr>
					</div>
				</div>
				<massage-types-gallery msg-types="{{ $massage_types }}"></massage-types-gallery>


			</div>
			@guest
				<opinion :login="false" :post-id="{{ $post->id }}"></opinion>
			@else
				<opinion :your-opinion="{{ $opinion ? $opinion : '{}' }}" :login="true" :post-id="{{ $post->id }}"></opinion>
			@endguest
		</div>


	</div>
</div>

@endsection
