<style scoped>
@import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
</style>
<template>
	<div class="row" style="margin-top:7rem;margin-right: 0;margin-left: 0">
		<div class="col-md-8 offset-md-2">
			<div class="box-container">
				<h1 class="text-center mb-5">Dodaj nowe ogłoszenie</h1>
				<hr>

				<form method="post" enctype="multipart/form-data" v-on:submit.prevent="onSubmit">
                    <input type="hidden" name="_token" v-bind:value="csrf">
                    <div class="form-group mt-4 align-items-center" style="font-size: 1.1em">
                        <div class="row" style="margin-top: 3rem;">
                            <div class="col-sm-2 col-lg-2 offset-lg-1 offset-md-1">
                                <label for="title" class="col-form-label">Tytuł</label>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <input required type="text" id="title" v-validate="'required'" v-model="user_fields.title" name="title" :class="{'wrong': errors.has('title')}" class="form-control">
                            </div>
                            <div clas="col-sm-3">
                                <span class="error">{{ errors.first('title') }}</span>
                            </div>
                        </div>

<!--                         <div class="row" style="margin-top: 2rem;">
                            <div class="col-sm-2 col-lg-2 offset-lg-1 offset-md-1">
                                <label for="price" class="col-form-label">Cena</label>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <input required type="text" id="price" v-validate="'required'" v-model="user_fields.price" name="price" :class="{'wrong': errors.has('price')}" class="form-control">
                            </div>
                            <div clas="col-sm-3">
                                <span class="error">{{ errors.first('price') }}</span>
                            </div>
                        </div> -->


                        <div class="row" style="margin-top: 3rem;">
                            <div class="col-sm-2 col-lg-2 offset-lg-1 offset-md-1">
                                <label for="description" class="col-form-label">Opis</label>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <textarea required id="description" v-validate="'required'" v-model="user_fields.description" name="description" :class="{'wrong': errors.has('description')}" class="form-control"></textarea>
                            </div>
                            <div clas="col-sm-3">
                                <span class="error">{{ errors.first('description') }}</span>
                            </div>
                        </div>

						<div class="row" style="margin-top: 2rem;">
                        	<div class="offset-3 col-lg-8 col-md-8">
		                        <div class="form-check">
								  <input class="form-check-input" type="radio" name="exampleRadios" id="noComp" value="1" checked>
  								<label class="form-check-label" for="noComp">
								    Nie posiadam firmy
								  </label>
								</div>
							</div>
						</div>

						<div class="row" style="margin-top: 0.5rem;">
                        	<div class="offset-3 col-lg-8 col-md-8">
		                        <div class="form-check">
								  <input class="form-check-input" type="radio" name="exampleRadios" id="Comp" value="2">
  								<label class="form-check-label" for="Comp">
								    Posiadam firmę
								  </label>
								</div>
							</div>
						</div>



                        <hr class="mt-5 mb-5">

                        <h3 class="text-center">Gdzie możesz zrealizować usługę</h3>


                        <div class="row" style="margin-top: 2rem;">
                        	<div class="offset-3 col-lg-8 col-md-8">
		                        <div class="form-check">
								  <input class="form-check-input" type="checkbox" v-model="to_client" value="" id="defaultCheck1">
								  <label class="form-check-label" for="defaultCheck1">
								    U klienta
								  </label>
								</div>
							</div>
						</div>

						<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
							<div class="row" style="margin-top: 1rem;" v-if="to_client">
	                            <div class="col-sm-2 col-lg-2 offset-lg-1 offset-md-1">
	                                <label for="loc" class="col-form-label">Obsługiwany obszar</label>
	                            </div>
	                            <div class="col-lg-8 col-md-8">
	                                <input required type="text" id="loc" v-validate="'required'" v-model="user_fields.loc" name="loc" :class="{'wrong': errors.has('loc')}" class="form-control" placeholder="np. Warszawa i okolice do 25km">
	                            </div>
	                            <div clas="col-sm-3">
	                                <span class="error">{{ errors.first('loc') }}</span>
	                            </div>
	                        </div>
                    	</transition>


						<div class="row" style="margin-top: 1rem;">
							<div class="offset-3 col-lg-8 col-md-8">
								<div class="form-check">
									<input class="form-check-input" v-model="to_masseur" type="checkbox" value="" id="defaultCheck2">
									<label class="form-check-label" for="defaultCheck2">
										U mnie
									</label>
								</div>
							</div>
						</div>

						<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
							<div v-if="to_masseur">
								<div class="row" style="margin-top: 1rem;">
		                            <div class="col-sm-1 col-lg-2 offset-lg-1 offset-md-1">
		                                <label for="city" class="col-form-label">Miejscowość</label>
		                            </div>
		                            <div class="col-lg-4 col-md-4">
		                                <input required type="text" id="city" v-validate="'required'" v-model="user_fields.city" name="city" :class="{'wrong': errors.has('city')}" class="form-control">
		                            </div>
		                        </div>
		                        <div class="row" style="margin-top: 1rem;">
		                            <div class="col-sm-1 col-lg-2 offset-lg-1 offset-md-1">
		                                <label for="province" class="col-form-label">Województwo</label>
		                            </div>
		                            <div class="col-lg-4 col-md-4">
		                                <input required type="text" id="province" v-validate="'required'" v-model="user_fields.province" name="province" :class="{'wrong': errors.has('province')}" class="form-control">
		                            </div>
		                        </div>
		                        <div class="row" style="margin-top: 1rem;">
		                            <div class="col-sm-1 col-lg-2 offset-lg-1 offset-md-1">
		                                <label for="street" class="col-form-label">Ulica</label>
		                            </div>
		                            <div class="col-lg-4 col-md-4">
		                                <input required type="text" id="street" v-validate="'required'" v-model="user_fields.street" name="street" :class="{'wrong': errors.has('street')}" class="form-control">
		                            </div>
		                        </div>
		                        <div class="row" style="margin-top: 1rem;">
		                            <div class="col-sm-1 col-lg-2 offset-lg-1 offset-md-1">
		                                <label for="number" class="col-form-label">Numer</label>
		                            </div>
		                            <div class="col-lg-2 col-md-2s">
		                                <input required type="text" id="number" v-validate="'required'" v-model="user_fields.number" name="number" :class="{'wrong': errors.has('number')}" class="form-control">
		                            </div>
		                        </div>
	                    	</div>
                    	</transition>

                     	<hr class="mt-5 mb-5">

                     	<h3 class="text-center">Oferowane rodzaje masażu</h3>

                     	<div class="d-flex mt-4 mx-auto" style="width: 40%">
                     		<select class="form-control my-auto" v-model="selectedType">
							  <option v-for="(type,index) in types" v-bind:key="index" v-bind:value="type">{{ type }}</option>
							</select>

							<div class="add-notice ml-5">
                 				<button class="plus-button my-auto" @click.prevent="AddNewMTC"></button>
                 			</div>
                     	</div>

                     	<div style="height: 10px"></div>

                     	<massage-type-component 
                     	v-on:delete-mtc="deleteThisMTC(mtc_data.id)" 
                     	v-bind:mtype="selectedType" 
                     	v-for="n in mtc_data" 
                     	v-bind:key="mtc_data.id"></massage-type-component>
<!--                    	<h3 class="text-center">Dodaj zdjęcia (max. 5)</h3>
                    	<input type="file" name="myImage" accept="image/*" />
                    	<input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true">
 -->
                    </div>
                </form>
			</div>
		</div>
	</div>
</template>

<style scoped>
.box-container{
	padding: 5em 3em;
}
</style>

<script>
import MassageTypeComponent from './MassageTypeComponent.vue'
	
export default{
	props:{
		s_user: String,
		csrf: String,
	},
	data(){
		return{
			user:{},
			user_fields: {},
			to_client: false,
			to_masseur: false,
			mtcCount:1,
			types:['Masaż klasyczny','Masaż relaksacyjny','Masaż głowy','Masaż stóp','Masaż tajski'],
			selectedType:'Masaż klasyczny',
			mtc_data:{
				"0":{id:0},
			}
		}
	},
	components:{
		"massage-type-component":MassageTypeComponent
	},
	methods:{
 		ChangeUserToObj() {
 			this.user = JSON.parse(this.s_user);
 		},
 		AddNewMTC(){
 			Vue.set(this.mtc_data,this.mtcCount,{id:this.mtcCount});
 			this.mtcCount+=1;
 			console.log(this.mtc_data);
	 	},
	 	deleteThisMTC: function(ix) {
            delete this.mtc_data[ix];
           	console.log(this.mtc_data);
        }
 	},
	beforeMount(){
	   this.ChangeUserToObj();
	},
}
</script>