@extends('layouts.app')

@section('title','Ogłoszenia masażystów i fizjoterapeutów')
@section('tree1','Ogłoszenia masażystów i fizjoterapeutów')

@section('content')
<div class="container" style="padding:1rem;min-width:100%;margin:0">
	<div class="row">
		<div class="col-sm-10 offset-sm-1">
			<div class="row">
				<div class="col-lg-10">
					<div class="post">
						<h1>Masażysta z dojazdem do pacjenta.Woj.podlaskie.</h1>
						<div class="row">
							<div class="col-sm-3"><span style="color:#09A2E5">Dodane przez: </span>Tadeusz Matyskiel</div>
							<div class="col-sm-3"><i class="far fa-clock" style="margin-right: 3%;color:#09A2E5"></i>03.07.2019</div>
							<div class="col-sm-3"><i class="fas fa-map-marker-alt" style="margin-right: 3%;color:#09A2E5"></i>Województwo Podlaskie</span></div>
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
					</div>

					@foreach ($ads as $ad)
						<div class="post mt-5">
						<h1>{{ $ad->title }}</h1>
						<div class="row">
							<div class="col-sm-3"><span style="color:#09A2E5">Dodane przez: </span>Tadeusz Matyskiel</div>
							<div class="col-sm-3"><i class="far fa-clock" style="margin-right: 3%;color:#09A2E5"></i>{{ $ad->created_at }}</div>
							<div class="col-sm-3"><i class="fas fa-map-marker-alt" style="margin-right: 3%;color:#09A2E5"></i>{{ $ad->area }}</span></div>
							<p class="post-description">
								{{ $ad->description }}
							</p>
						</div>
						<div class="row">
							<div class="col-sm-3 offset-9">
								<button class="btn button_slide slide_right p-3">Dowiedz się więcej</button>
							</div>
						</div>
					</div>
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
				</div>
			</div>
		</div>	
	</div>
</div>
@endsection