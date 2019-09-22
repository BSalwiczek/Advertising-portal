<template>
	<div class="text-center p-3 pt-5">
		<loader v-if="loading"></loader>
		<div v-else>
			<h1 class="pb-3">Edycja ogłoszenia</h1>
			<hr class="mx-2" />

			<form method="post" enctype="multipart/form-data" v-on:submit.prevent="submit" class="mt-5" style="font-size: 1.2em">
		                    <!-- <input type="hidden" name="_token" v-bind:value="csrf"> -->
            <div class="row align-items-center mx-auto" style="width: 80%; justify-content: center;">
                <div class="col-sm-2 col-lg-2">
                    <label for="title" class="col-form-label">Tytuł</label>
                </div>
                <div class="col-lg-9 col-md-9">
                    <input required type="text" id="title" v-validate="'required|max:100'" v-model="user_fields.title" name="title" :class="{'wrong': errors.has('title')}" class="form-control">
                    <span class="error">{{ errors.first('title') }}</span>
                </div>
            </div>

            <div class="row align-items-center mx-auto" style="margin-top: 2rem;width: 80%; justify-content: center;">
                <div class="col-sm-2 col-lg-2">
                    <label for="description" class="col-form-label">Opis</label>
                </div>
                <div class="col-lg-9 col-md-9">
                    <textarea required id="description" v-validate="'required'" v-model="user_fields.description" name="description" :class="{'wrong': errors.has('description')}" class="form-control"></textarea>
                    <span class="error">{{ errors.first('description') }}</span>
                </div>
            </div>

											<!-- <div class="row" style="margin-top: 2rem;">
					                        	<div class="offset-3 col-lg-8 col-md-8">
							                        <div class="form-check">
													  <input class="form-check-input" v-model="user_fields.company" type="radio" name="company" id="noComp" value="1" checked>
					  									<label class="form-check-label" for="noComp">
													    Nie posiadam firmy
													  	</label>
													</div>
												</div>
											</div> -->

											<!-- <div class="row" style="margin-top: 0.5rem;">
					                        	<div class="offset-3 col-lg-8 col-md-8">
							                        <div class="form-check">
													  <input class="form-check-input" v-model="user_fields.company" type="radio" name="company" id="Comp" value="2">
					  								<label class="form-check-label" for="Comp">
													    Posiadam firmę
													  </label>
													</div>
												</div>
											</div> -->


                      <hr class="mt-5 mb-5">

                      <h3 class="text-center">Gdzie możesz zrealizować usługę</h3>

                      <div class="row align-items-center mx-auto" style="margin-top: 2rem;width: 80%; justify-content: center;">
												<label>
														<input class="inp-cbx" id="to_client" name="where" type="checkbox" style="display: none;"/>
													<label class="cbx" for="to_client"><span>
															<svg width="12px" height="10px" viewbox="0 0 12 10">
																<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
															</svg></span><span>U klienta</span>
													</label>
												</label>
                      	<!-- <div class="offset-3 col-lg-8 col-md-8">
	                        <div class="form-check">
		                        <label class="form-check-label" for="to_client">
												  <input
												  class="form-check-input"

												  type="checkbox"
												  v-model="user_fields.where"
												  id="to_client"
												  name="where"
													:value="where.to_client.id"
												  v-validate="'required'">

												    U klienta
												</label>
												</div>
											</div> -->
										</div>

								<!-- <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
								<div class="row" style="margin-top: 1rem;" v-if="show_options(0)">
                        <div class="col-sm-2 col-lg-2 offset-lg-1 offset-md-1">
                            <label for="area" class="col-form-label">Obsługiwany obszar</label>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <input required type="text" id="area" v-validate="'required'" v-model="user_fields.area" name="area" :class="{'wrong': errors.has('area')}" class="form-control" placeholder="np. Warszawa i okolice do 25km">
                            <span class="error">{{ errors.first('area') }}</span>
                        </div>
                    </div>
              	</transition> -->


								<!-- <div class="row" style="margin-top: 1rem;">
									<div class="offset-3 col-lg-8 col-md-8">
										<div class="form-check">
											<label class="form-check-label"  for="to_masseur">
												<input
												v-validate="'required'"
												:value="where.to_masseur.id"
												class="form-check-input"
												ref="to_masseur"
												v-model="user_fields.where"
												type="checkbox"
												name="where"
												id="to_masseur">
												U mnie
											</label>
										</div>
										<span class="error">{{ errors.first('where') }}</span>
									</div>
								</div>

								<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
									<div v-if="show_options(1)">
										<div class="row" style="margin-top: 1rem;">
                          <div class="col-sm-1 col-lg-2 offset-lg-1 offset-md-1">
                              <label for="city" class="col-form-label">Miejscowość</label>
                          </div>
                          <div class="col-lg-4 col-md-4">
                              <input required type="text" id="city" v-validate="'required'" v-model="user_fields.city" name="city" :class="{'wrong': errors.has('city')}" class="form-control">
                              <span class="error">{{ errors.first('city') }}</span>
                          </div>
                      </div>
                      <div class="row" style="margin-top: 1rem;">
                          <div class="col-sm-1 col-lg-2 offset-lg-1 offset-md-1">
                              <label for="province" class="col-form-label">Województwo</label>
                          </div>
                          <div class="col-lg-4 col-md-4">
                              <input required type="text" id="province" v-validate="'required'" v-model="user_fields.province" name="province" :class="{'wrong': errors.has('province')}" class="form-control">
                              <span class="error">{{ errors.first('province') }}</span>
                          </div>
                      </div>
                      <div class="row" style="margin-top: 1rem;">
                          <div class="col-sm-1 col-lg-2 offset-lg-1 offset-md-1">
                              <label for="street" class="col-form-label">Ulica</label>
                          </div>
                          <div class="col-lg-4 col-md-4">
                              <input required type="text" id="street" v-validate="'required'" v-model="user_fields.street" name="street" :class="{'wrong': errors.has('street')}" class="form-control">
                              <span class="error">{{ errors.first('street') }}</span>
                          </div>
                      </div>
                      <div class="row" style="margin-top: 1rem;">
                          <div class="col-sm-1 col-lg-2 offset-lg-1 offset-md-1">
                              <label for="number" class="col-form-label">Numer</label>
                          </div>
                          <div class="col-lg-2 col-md-2s">
                              <input required type="text" id="number" v-validate="'required'" v-model="user_fields.number" name="number" :class="{'wrong': errors.has('number')}" class="form-control">
                              <span class="error">{{ errors.first('number') }}</span>
                          </div>
                      </div>
                	</div>
              	</transition>

               	<hr class="mt-5 mb-5">

               	<h3 class="text-center">Oferowane rodzaje masażu</h3>

               	<div class="d-flex mt-4 mx-auto" style="width: 60%">

									<div class="add-notice ml-5 d-flex mx-auto">
	                 	<button class="plus-button my-auto" @click.prevent="AddNewMTC"></button>
										<span class="my-auto ml-2" @click="AddNewMTC">Dodaj nowy rodzaj</span>
		              </div>
		           	</div>

		                     	<div style="height: 10px"></div>

		                     	<div class="row mx-auto" style="width: 97%">
			                     	<massage-type-component
			                     	v-on:delete-mtc="deleteThisMTC(index)"
			                     	v-for="(n,index) in mtc_data"
			                     	v-bind:key="index"
			                     	v-model="mtc_data[index]"
			                     	></massage-type-component>
			                    </div>

		  						<div class="mx-auto text-center">
		                        <button class="btn btn-first w-50" style="font-size: 1.4em;margin-top: 6rem;">
		                            Dodaj nowe ogłoszenie!
		                        </button>
		                    </div>

                    <form ref="redform" action="/dodano-nowe-ogloszenie" method="post">
                    	<input type="hidden" name="_token" v-bind:value="csrf">
                	</form> -->
            </form>
		</div>
	</div>
</template>

<script>
import loaderComp from '../../others/LoadingComponent.vue';
export default{
	data(){
		return{
			loading: true,
			user_fields: {}
		}
	},
	components:{
		'loader':loaderComp
	},
	mounted(){
		axios.get('/get-ad-data').then((response)=>{
			this.loading = false;
			this.user_fields.title = response.data.title;
			this.user_fields.description = response.data.description;
			console.log(response)
		});
	}
}
</script>
