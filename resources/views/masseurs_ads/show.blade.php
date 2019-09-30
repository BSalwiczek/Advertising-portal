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
		<div class="col-md-3">
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

			<div class="box-container mt-2 px-3 pl-lg-5 pl-2">
				<h5><i style="margin-right: 1%; color: rgb(9, 162, 229);" class="fas fa-user-graduate"></i> Wykształcenie</h5>
				@php
				$catExist = false
				@endphp
				@foreach ($educoexp as $key => $value)
					@if($value->category=='education')
						@php
						$catExist = true
						@endphp
						@if($value->to !== null and $value->to != '')
							<span><b>{{ $value->since }} - {{ $value->to }}</b>&nbsp;&nbsp;{{ $value->description }}</span><br />
						@else
							<span><b>{{ $value->since }}</b>&nbsp;&nbsp;{{ $value->description }}</span><br />
						@endif
					@endif
				@endforeach
				@if(!$catExist)
					<span style="opacity:0.7">Nie dodano</span>
				@endif

				<h5 class="mt-3"><i style="margin-right: 1%; color: rgb(9, 162, 229);" class="fas fa-chalkboard-teacher"></i> Kursy i szkolenia</h5>

				@php
				$coExist = false
				@endphp
				@foreach ($educoexp as $key => $value)
					@if($value->category=='courses')
						@php
						$coExist = true
						@endphp
						@if($value->to !== null and $value->to != '')
							<span><b>{{ $value->since }} - {{ $value->to }}</b>&nbsp;&nbsp;{{ $value->description }}</span><br />
						@else
							<span><b>{{ $value->since }}</b>&nbsp;&nbsp;{{ $value->description }}</span><br />
						@endif
					@endif
				@endforeach
				@if(!$coExist)
					<span style="opacity:0.7">Nie dodano</span>
				@endif

				<h5 class="mt-3"><i style="margin-right: 1%; color: rgb(9, 162, 229);" class="fas fa-medal"></i> Doświadczenie</h5>
				@php
				$expExist = false
				@endphp
				@foreach ($educoexp as $key => $value)
					@if($value->category=='experience')
						@php
						$expExist = true
						@endphp
						@if($value->to !== null and $value->to != '')
							<span><b>{{ $value->since }} - {{ $value->to }}</b>&nbsp;&nbsp;{{ $value->description }}</span><br />
						@else
							<span><b>{{ $value->since }}</b>&nbsp;&nbsp;{{ $value->description }}</span><br />
						@endif
					@endif
				@endforeach
				@if(!$expExist)
					<span style="opacity:0.7">Nie dodano</span>
				@endif

			</div>



		{{-- {{ $post->user->name }}
		{{ $post->created_at }} --}}
		</div>
		<div class="col-md-9 ad-description mt-3 mt-md-0">

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
