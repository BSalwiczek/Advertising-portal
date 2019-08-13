@extends('layouts.app')

@section('title','Ogłoszenia masażystów')
@section('tree1','Ogłoszenia masażystów')

@section('content')
<div class="container" style="padding:1rem;min-width:100%;margin:0">
	<div class="row">
		<div class="col-sm-10 offset-sm-1">

			<filter-ads ref="filter" csrf="{{ csrf_token() }}" s_previous_filters="{{ $prev_data }}"></filter-ads>


			<div class="row">
				<div class="col-lg-10">
{{-- 					<div class="post">
						<h1>Masażysta z dojazdem do pacjenta.Woj.podlaskie.</h1>
						<div class="row">
							<div class="col-sm-3"><span style="color:#09A2E5">Dodane przez: </span>Tadeusz Matyskiel</div>
							<div class="col-sm-3"><i class="far fa-clock" style="margin-right: 3%;color:#09A2E5"></i>03.07.2019</div>
							<div class="col-sm-6"><i class="fas fa-map-marker-alt" style="margin-right: 3%;color:#09A2E5"></i>Województwo Podlaskie</span></div>
							<p class="post-description">
								Profesjonalny masaż, skuteczne, najnowsze techniki masażu. 
		Rozsądne ceny. Na wszelkie pytania odpowiadam telefonicznie. Masażysta z dużym doświadczeniem .Stosujemy najnowsze ,sprawdzone i najważniejsze,skuteczne techniki masażu Pomagamy skutecznie w zespołach bólowych wszystkich odcinków kręgosłupa, barków, kończyn, dłoni, stóp. Przed każdym zabiegiem przeprowadzamy dokładny wywiad z pacjentem oraz badanie w celu dobrania najbardziej skutecznych technik masażu. Wykonujemy również masaż relaksacyjny i bańką chińską całościowy lub poszczególnych partii ciała.
							</p>
						</div>
						<div class="row">
							<div class="col-sm-3 offset-9">
								<button class="btn button_slide slide_right p-3">Dowiedz się więcej</button>
							</div>
						</div>
					</div> --}}

					<div class="row mb-3">
						<div class="col-md-6">
							@if ($posts_count % (int)strlen(strval($posts_count))<5)
								<h3>Znaleziono <strong>{{ $posts_count }}</strong> ogłoszenia</h3>
							@else
								<h3>Znaleziono <strong>{{ $posts_count }}</strong> ogłoszeń</h3>
							@endif
							<hr style="width: 30%" class="ml-0">
						</div>
						<div class="col-md-6">
							<sort-ads s_previous_sorting="{{ $prev_data }}"></sort-ads>
						</div>
					</div>

					@foreach ($ads as $key => $ad)
						<show-ad s_ad="{{ $ad }}" s_user="{{ $ad->user }}" offset="{{ $key }}" s_massage_prices="{{ $prices }}"></show-ad>
					@endforeach
					
				</div>
				<div class="col-lg-2">
					@auth
						@if(Auth::user()->role==0)
							<a href="masazysta/dodaj-nowe-ogloszenie" style="color:inherit;">
								<div class="d-flex add-notice">
									<button class="plus-button my-auto"></button>
									<span class="my-auto ml-2">Dodaj nowe ogłoszenie</span>
								</div>
							</a>
						@endif
					@endauth
					@if(Cookie::get('added_post'))
						<alert-success></alert-success>
						{{ Cookie::queue(Cookie::forget('added_post')) }}
					@endif
				</div>
			</div>
		</div>

	</div>

	<div class="mx-auto text-center">
		{!! $ads->appends(request()->input())->links() !!}
	</div>
	
</div>
@endsection