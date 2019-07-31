<style scoped>
@import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
</style>
<template>
	<div class="row" style="margin-top:7rem;margin-right: 0;margin-left: 0">
		<div class="col-md-8 offset-md-2">
			<div class="box-container">
				<h1 class="text-center mb-5">Dodaj nowe ogłoszenie</h1>
				<hr>

				<form method="post" enctype="multipart/form-data" v-on:submit.prevent="submit">
                    <input type="hidden" name="_token" v-bind:value="csrf">
                    <div class="form-group mt-4 align-items-center" style="font-size: 1.1em">
                        <div class="row" style="margin-top: 3rem;">
                            <div class="col-sm-2 col-lg-2 offset-lg-1 offset-md-1">
                                <label for="title" class="col-form-label">Tytuł</label>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <input required type="text" id="title" v-validate="'required|max:100'" v-model="user_fields.title" name="title" :class="{'wrong': errors.has('title')}" class="form-control">
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
                                <span class="error">{{ errors.first('description') }}</span>
                            </div>
                        </div>

						<div class="row" style="margin-top: 2rem;">
                        	<div class="offset-3 col-lg-8 col-md-8">
		                        <div class="form-check">
								  <input class="form-check-input" v-model="user_fields.company" type="radio" name="company" id="noComp" value="1" checked>
  									<label class="form-check-label" for="noComp">
								    Nie posiadam firmy
								  	</label>
								</div>
							</div>
						</div>

						<div class="row" style="margin-top: 0.5rem;">
                        	<div class="offset-3 col-lg-8 col-md-8">
		                        <div class="form-check">
								  <input class="form-check-input" v-model="user_fields.company" type="radio" name="company" id="Comp" value="2">
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
			                        <label class="form-check-label" for="to_client">
									  <input 
									  class="form-check-input" 
									  :value="where.to_client.id"
									  type="checkbox" 
									  v-model="user_fields.where" 
									  id="to_client" 
									  name="where" 
									  v-validate="'required'">
									  
									    U klienta
									</label>
								</div>
							</div>
						</div>

						<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
							<div class="row" style="margin-top: 1rem;" v-if="show_options(0)">
	                            <div class="col-sm-2 col-lg-2 offset-lg-1 offset-md-1">
	                                <label for="area" class="col-form-label">Obsługiwany obszar</label>
	                            </div>
	                            <div class="col-lg-8 col-md-8">
	                                <input required type="text" id="area" v-validate="'required'" v-model="user_fields.area" name="area" :class="{'wrong': errors.has('area')}" class="form-control" placeholder="np. Warszawa i okolice do 25km">
	                                <span class="error">{{ errors.first('area') }}</span>
	                            </div>
	                        </div>
                    	</transition>


						<div class="row" style="margin-top: 1rem;">
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
<!--                      		<select class="form-control my-auto" v-model="selectedType">
							  <option v-for="(type,index) in types" v-bind:key="index" v-bind:value="type">{{ type }}</option>
							</select> -->

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
                    	</form>




                     	<!-- v-bind:mtype="n.name" -->
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
			where: {
				to_client:{
					id: 0,
				},
				to_masseur:{
					id: 1,
				}
			},
			user_fields: {
				company: "1",
				where: [0]
				
			},
			mtcCount:1,
			types:['Masaż klasyczny','Masaż relaksacyjny','Masaż głowy','Masaż stóp','Masaż tajski','Inny'],
			selectedType:'Masaż klasyczny',
			mtc_data:{
				"0":{
					id:0,
					name:'',
					image: {},
					description: '',
					price: '',
					duration: '',
				},
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
 			Vue.set(this.mtc_data,this.mtcCount,{id:this.mtcCount, name: '',description: '',price: ''});
 			this.mtcCount+=1;
	 	},
	 	deleteThisMTC: function(ix) {
	 		
	 		this.$delete(this.mtc_data,ix);
           	
        },
		submit(){
			this.$validator.validateAll().then(value => {
		    if (value) {

		      var formData = new FormData();

		      for(var key in this.user_fields)
		      {
		      	formData.append(key,this.user_fields[key]);
		      }

		      var user_data = this.user_fields;
		      user_data.mtc_data = this.mtc_data;

		      var json_mtc = JSON.stringify(user_data.mtc_data);
		      formData.append('mtc_data',json_mtc);


		      for(var key in user_data.mtc_data)
		      {
		      	formData.append(("image"+String(key)),user_data.mtc_data[key].image);
		      }

		   //    for (var key of formData.entries()) {
			  //   console.log(key[0] + ', ' + key[1]);
			  // }
		      
		      axios.post('/masazysta/dodaj-nowe-ogloszenie', formData,{headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
		      	console.log(response.data);
                if(response.data=='success'){
                	 this.$refs.redform.submit();
                }
	          }).catch(error => {
	            console.log(error);
	          });
		    }
		  })
		},
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
		}

 	},
	beforeMount(){
	   this.ChangeUserToObj();
	},
}
</script>