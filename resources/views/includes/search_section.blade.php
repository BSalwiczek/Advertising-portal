<div class="container vertical-center" style="height: 250px;background-color: #7CD4FA;min-width: 100%; transition: height 2s;">
	<div class="row" style="min-width: 100%">
		<div class="col-sm-6 offset-3 search-container">
			<form>
				@csrf
				<div class="form-row align-items-center">
					<div class="col-auto mr-2 ml-3">
						<img height="30" width="30" src="storage/search_select.png">
					</div>
					<div class="col">
				      <label class="sr-only" for="inlineFormInput">Name</label>
				      <input type="text" class="form-control search-form" id="inlineFormInput" placeholder="np. Masażysta w Warszawie">
				    </div>
				    <div class="col-auto">
				      <select class="custom-select custom-select-lg mr-sm-2 search-form" id="inlineFormCustomSelect">
				        <option selected value="1">Masażysta</option>
				        <option value="3">Klient</option>
				        <option value="4">Firma</option>
				      </select>
				    </div>
				    <div class="col-auto">
				    	<button class="btn search-button mr-3 p-2 pr-3 pl-3" type="submit">Szukaj</button>
				    </div>
				</div>
			</form>
		</div>
	</div>
</div>