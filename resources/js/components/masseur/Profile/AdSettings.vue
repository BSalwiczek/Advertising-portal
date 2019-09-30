<template>
	<div class="text-center p-3 pt-5">
		<transition leave-active-class="animated fadeOut fast">
			<loader v-if="loading"></loader>
		</transition>
		<div v-if="!	loading">
			<h1 class="pb-3">Edycja ogłoszenia</h1>
			<hr class="my-2 w-75 mx-auto" />

			<form method="post" enctype="multipart/form-data" v-on:submit.prevent="submit" class="mt-5" style="font-size: 1.2em">
		     <input type="hidden" name="_token" v-bind:value="csrf">
            <div class="row align-items-center mx-auto" style="width: 80%; justify-content: center;">
                <div class="col-2">
                    <label for="title" class="col-form-label">Tytuł</label>
                </div>
                <div class="col-9">
                    <input required type="text" id="title" v-validate="'required|max:100'" v-model="user_fields.title" name="title" :class="{'wrong': errors.has('title')}" class="form-control">
                    <span class="error">{{ errors.first('title') }}</span>
                </div>
            </div>

            <div class="row align-items-center mx-auto" style="margin-top: 2rem;width: 80%; justify-content: center;">
                <div class="col-2">
                    <label for="description" class="col-form-label">Opis</label>
                </div>
                <div class="col-9">
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

                      <h3 class="text-center mt-5 pb-3">Gdzie możesz zrealizować usługę</h3>

											<hr class="my-2 w-50">

                      <div class="row align-items-center mx-auto" style="margin-top: 2rem;width: 80%; justify-content: center;">
													<label>
															<input
															class="inp-cbx"
															id="to_client"
															name="where"
															v-model="user_fields.where"
															:value="where.to_client.id"
															v-validate="'required'"
															type="checkbox"
															style="display: none;"/>
														<label class="cbx" for="to_client"><span>
																<svg width="12px" height="10px" viewbox="0 0 12 10">
																	<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
																</svg></span><span>U klienta</span>
														</label>
													</label>
											</div>

								<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
										<div class="row align-items-center mx-auto mt-3 mb-4" style="justify-content: center" v-if="show_options(0)">
                        <div class="col-2">
                            <label for="area" class="col-form-label">Obsługiwany obszar</label>
                        </div>
                        <div class="col-7">
                            <input required type="text" id="area" v-validate="'required'" v-model="user_fields.area" name="area" :class="{'wrong': errors.has('area')}" class="form-control" placeholder="np. Warszawa i okolice do 25km">
                            <span class="error">{{ errors.first('area') }}</span>
                        </div>
                    </div>
              	</transition>


								<div class="row align-items-center mx-auto mt-2" style="width: 80%; justify-content: center;">
										<label>
												<input
												class="inp-cbx"
												id="to_masseur"
												name="where"
												v-model="user_fields.where"
												:value="where.to_masseur.id"
												v-validate="'required'"
												type="checkbox"
												style="display: none;"/>
											<label class="cbx" for="to_masseur"><span>
													<svg width="12px" height="10px" viewbox="0 0 12 10">
														<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
													</svg></span><span>U siebie</span>
											</label>
										</label>

								</div>
								<span class="error text-center">{{ errors.first('where') }}</span>


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
								</div> -->

								<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
									<div v-if="show_options(1)">
										<div class="row align-items-center mx-auto mt-3" style="justify-content: center">
                          <div class="col-2">
                              <label for="city" class="col-form-label">Miejscowość</label>
                          </div>
                          <div class="col-4">
                              <input required type="text" id="city" v-validate="'required'" v-model="user_fields.city" name="city" :class="{'wrong': errors.has('city')}" class="form-control">
                              <span class="error">{{ errors.first('city') }}</span>
                          </div>
                      </div>
                      <div class="row align-items-center mx-auto mt-3" style="justify-content: center">
                          <div class="col-2">
                              <label for="province" class="col-form-label">Województwo</label>
                          </div>
                          <div class="col-4">
                              <input required type="text" id="province" v-validate="'required'" v-model="user_fields.province" name="province" :class="{'wrong': errors.has('province')}" class="form-control">
                              <span class="error">{{ errors.first('province') }}</span>
                          </div>
                      </div>
                      <div class="row align-items-center mx-auto mt-3" style="justify-content: center">
                          <div class="col-2">
                              <label for="street" class="col-form-label">Ulica</label>
                          </div>
                          <div class="col-4">
                              <input required type="text" id="street" v-validate="'required'" v-model="user_fields.street" name="street" :class="{'wrong': errors.has('street')}" class="form-control">
                              <span class="error">{{ errors.first('street') }}</span>
                          </div>
                      </div>
                      <div class="row align-items-center mx-auto mt-3" style="justify-content: center">
                          <div class="col-2">
                              <label for="number" class="col-form-label">Numer</label>
                          </div>
                          <div class="col-2">
                              <input required type="text" id="number" v-validate="'required'" v-model="user_fields.number" name="number" :class="{'wrong': errors.has('number')}" class="form-control">
                              <span class="error">{{ errors.first('number') }}</span>
                          </div>
													/
													<div class="col-2">
                              <input required type="text" id="number" v-validate="'required'" v-model="user_fields.number" name="number" :class="{'wrong': errors.has('number')}" class="form-control">
                              <span class="error">{{ errors.first('number') }}</span>
                          </div>
                      </div>
                	</div>
              	</transition>

               	<!--<hr class="mt-5 mb-5">

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
 -->
		  									<div class="row align-items-center mx-auto my-5" style="justify-content: center">
													<div class="col-sm-6 col-12">
														<button class="btn btn-first" style="font-size: 1.4em; width: 100%">
		                            Zapisz zmiany
		                        </button>
													</div>

		                    </div>
            </form>
						<alert-success ref="alertS" message="<strong>Gratulacje!</strong> Zmiany zostały zapisane." :showNow="false"></alert-success>
		</div>
	</div>
</template>

<script>
import loaderComp from '../../others/LoadingComponent.vue';
import alertComp from '../../alerts/AlertSuccessComponent.vue';
export default{
	data(){
		return{
			loading: true,
			user_fields: {
				where: []
			},
			where: {
				to_client:{
					id: 0,
				},
				to_masseur:{
					id: 1,
				}
			}
		}
	},
	props:{
		'csrf': String
	},
	components:{
		'loader':loaderComp,
		'alert-success':alertComp
	},
	mounted(){
		axios.get('/get-ad-data').then((response)=>{
			this.loading = false;
			this.user_fields.title = response.data.title;
			this.user_fields.description = response.data.description;
			if(response.data.area != null)
			{
				this.user_fields.where.push(0);
				this.user_fields.area = response.data.area;
			}
			if(response.data.city != null)
			{
				this.user_fields.where.push(1);
				this.user_fields.city = response.data.city;
				this.user_fields.province = response.data.province;
				this.user_fields.street = response.data.street;
				this.user_fields.number = response.data.number;
			}
			console.log(response)
		});
	},
	methods:{
		show_options(index){
			if(index==0){
				if(this.user_fields.where.indexOf(0)==-1)
					return false;
				else
					return true
			}else{
				if(this.user_fields.where.indexOf(1)==-1)
					return false;
				else
					return true
			}
		},
		submit(){
			this.$validator.validateAll().then(value => {
				if(value){
					axios.post('/masazysta/zmien-ogloszenie', this.user_fields).then(response => {
						this.$refs.alertS.show = true;
		      	console.log(response.data);
	          }).catch(error => {
	            console.log(error);
	          });
				}
			})
		}
	}
}
</script>
