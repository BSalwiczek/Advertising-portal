<template>
	<div class="text-center p-3 pt-5">
		<h1>Ustawienia użytkownika</h1>
		<form method="post" enctype="multipart/form-data" v-on:submit.prevent="submit">
            <input type="hidden" name="_token" v-bind:value="csrf">
	        <!-- <div class="form-group mt-4 align-items-center" style="font-size: 1.1em">
	            <div class="row" style="margin-top: 3rem;">
	                <div class="col-sm-2 col-lg-2 offset-lg-1 offset-md-1">
	                    <label for="title" class="col-form-label">Tytuł</label>
	                </div>
	                <div class="col-lg-8 col-md-8">
	                    <input required type="text" id="title" name="title" class="form-control">
	                    <span class="error"></span>
	                </div>

	            </div>
	        </div> -->
	        <label for="name" class="inp mt-5 d-block">
			  <input required v-validate="'required|max:30|alpha'" type="text" id="name" v-model="user.name" class="better-input" placeholder=" " name="name" :class="{'wrong': errors.has('name')}">
			  <span class="label">Imie</span>
			  <span class="border-b"></span>
			</label>
			<span class="error">{{ errors.first('name') }}</span>

			<label for="surname" class="inp d-block" style="margin-top: 2.5rem">
			  <input required v-validate="'required|max:30|alpha'" type="text" id="surname" v-model="user.surname" class="better-input" name="surname" placeholder=" " :class="{'wrong': errors.has('surname')}">
			  <span class="label">Nazwisko</span>
			  <span class="border-b"></span>
			</label>
			<span class="error">{{ errors.first('surname') }}</span>

			<div class="text-center">
				<button class="btn btn-first p-3 mt-5">Zapisz zmiany</button>
			</div>
				
			<transition leave-active-class="animated fadeOut fast">
			<loader v-if="loading"></loader>
			</transition>
			
		</form>
		<alert-success v-on:alert-closed="changed=false" message="Ustawienia użytkownika zostały zmienione" v-if="changed"></alert-success>
	</div>
</template>

<style type="text/css" scoped>

</style>

<script type="text/javascript">
import alertsuccess from '../../alerts/AlertSuccessComponent.vue';
import loadingComponent from '../../others/LoadingComponent.vue';
export default{
	data(){
		return{
			user: {},
			changed: false,
			loading: false,
		}
	},
	props:{
		userData: Object,
		csrf: String,
	},
	mounted(){
		this.user = {...this.userData};

	},
	components:{
		'alert-success':alertsuccess,
		'loader':loadingComponent,
	},
	methods:{
		submit(){
			if(this.user.name != this.userData.name || this.user.surname != this.userData.surname){
			this.$validator.validateAll().then((result) => {
                if (result) {
                	var component = this;
                	this.loading = true;
					axios.post('/zapisz-ustawienia-uzytkownika-masazysty',this.user).then(function(response){
						component.loading = false;
						if(response.status == 200){
							component.changed = true;
						}
					})
                }
            });
			}
		}
	}
}
</script>