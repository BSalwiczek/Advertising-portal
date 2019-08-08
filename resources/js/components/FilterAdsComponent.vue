<template>
	<form method="get" action="/masazysci">

				<div class="filter-box mt-3 mb-5 dynamic-font">
					<div class="row">
						<input class="d-none" name="uc" value="0">
						<div class="col-lg-2 col-md-4 col-sm-6">
							<span>Typ masażu</span><br>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<span>Ocena masażysty</span><br>
							<input v-if="selected_filters.masseur_note!=0" name="masseur_note" :value="selected_filters.masseur_note" class="d-none">
							<dropdown :options="filters.masseur_note.options" 
							  :selected="getSelectedMN()" 
							  v-on:updateOption="changeMasseurNote">
							</dropdown>
						</div>
						<div class="col-lg-2 col-md-4 col-sm-6">
							<span>Ilość ocen</span><br>
							<input v-if="selected_filters.masseur_notes_count!=0" name="masseur_notes_count" :value="selected_filters.masseur_notes_count" class="d-none">
							<dropdown :options="filters.masseur_notes_count.options" 
							  :selected="getSelectedMNC()" 
							  v-on:updateOption="changeMasseurNotesCount">
							</dropdown>
						</div>
						<div class="col-lg-2 col-md-4 mt-md-5 col-sm-6 mt-xs-3 mt-lg-0">
							<span>Ilość opinii</span><br>
							<input v-if="selected_filters.masseur_opinions_count!=0" name="masseur_opinions_count" :value="selected_filters.masseur_opinions_count" class="d-none">
							<dropdown :options="filters.masseur_opinions_count.options" 
							  :selected="getSelectedMOC()" 
							  v-on:updateOption="changeMasseurOpinionsCount">
							</dropdown>
						</div>
						<div class="col-lg-2 col-md-4 mt-md-5 col-sm-6 mt-xs-3 mt-lg-0">
							<input name="city" v-if="selected_filters.city!=''" :value="selected_filters.city" class="d-none">
							<span>Miejscowość</span><br>
							<dropdown-search 
							  v-on:updateOption="changeCity"
							  :selected="selected_filters.city">
							</dropdown-search>
						</div>
						<div class="col-lg-2 col-md-4 mt-md-5 col-sm-6 mt-xs-3 mt-lg-0">
							<span>Województwo</span><br>
						</div>
					</div>
					<div class="row mt-4 mb-3">
						<div class="col-lg-2 col-sm-6 mt-xs-3 mt-lg-0">
							<input class="inp-cbx" name="to_client" id="cbx1" v-model="selected_filters.to_client" type="checkbox" style="display: none;"/>
							<label class="cbx" for="cbx1"><span>
							    <svg width="12px" height="10px" viewbox="0 0 12 10">
							      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
							    </svg></span><span>Dojazd do klienta</span>
							</label>
						</div>
						<div class="col-lg-2 col-sm-6 mt-xs-3 mt-lg-0">
							<input class="inp-cbx" id="cbx2" name="to_masseur" v-model="selected_filters.to_masseur" type="checkbox" style="display: none;"/>
							<label class="cbx" for="cbx2"><span>
							    <svg width="12px" height="10px" viewbox="0 0 12 10">
							      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
							    </svg></span><span>U masażysty</span>
							</label>
						</div>
					</div>

					<!-- {{ selected_filters }} -->
					<div class="row">
						<div class="col-md-2 offset-md-10 col-sm-6 offset-sm-3 text-center">
							<button class="btn btn-first p-3">Filtruj <i class="fas fa-filter"></i></button>
						</div>
					</div>
				</div>
<!-- 				{{ selected_filters }}	 -->
			</form>
</template>

<style type="text/css" scoped>
.filter-box{
  width: 100%;
  background-color: #FFF;
    -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.03);
  -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.03);
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.03);
  padding: 2%;
}

.filter-input{
	color: #636b6f;
  min-width: 160px;
  padding: 10px;
  text-transform: none;
  font-weight: 300;
  margin-bottom: 7px;
  border: 0;
  background-image: linear-gradient(#009688, #009688), linear-gradient(#D2D2D2, #D2D2D2);
  background-size: 0 2px, 100% 1px;
  background-repeat: no-repeat;
  background-position: center bottom, center calc(100% - 1px);
  background-color: transparent;
  transition: background 0s ease-out;
  float: none;
  box-shadow: none;
  border-radius: 0;
}
.filter-input:active,.filter-input:focus{
	box-shadow: none;
	border:none;
	outline: none;
}

.dynamic-font{
	font-size: 0.9vw;
}
@media screen and (max-width: 992px) {
  .dynamic-font{
	font-size: 1.4vw;
}
}
@media screen and (max-width: 500px) {
  .dynamic-font{
	font-size: 2.48vw;
}
}




</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>


<script type="text/javascript">
import dropdown from './DropdownComponent.vue';
import dropdownsearch from './DropdownSearchComponent.vue';

export default {
data() {
	  return {

	  	filters:{
	  		masseur_note: {
	  			options: [
	  			{id:0,name:'Wszystkie'},
	  			{id:1,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> i więcej'},
	  			{id:2,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i>  i więcej'},
	  			{id:3,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i>  i więcej'},
	  			{id:4,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i>  i więcej'},
	  			{id:5,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i>'},
	  			]
	  		},
	  		masseur_notes_count:{
	  			options: [
	  			{id: 0,name:'Wszystkie'},
	  			{id: 1,name:'Wiecej niż 5'},
	  			{id: 2,name:'Wiecej niż 10'},
	  			{id: 3,name:'Wiecej niż 20'},
	  			{id: 4,name:'Wiecej niż 50'},
	  			{id: 5,name:'Wiecej niż 100'},
	  			{id: 6,name:'Wiecej niż 150'},
	  			{id: 7,name:'Wiecej niż 200'},
	  			{id: 8,name:'Wiecej niż 300'},
	  			{id: 9,name:'Wiecej niż 500'},
	  			{id: 10,name:'Wiecej niż 1000'},
	  			]
	  		},
	  		masseur_opinions_count:{
	  			options: [
	  			{id: 0,name:'Wszystkie'},
	  			{id: 1,name:'Wiecej niż 5'},
	  			{id: 2,name:'Wiecej niż 10'},
	  			{id: 3,name:'Wiecej niż 20'},
	  			{id: 4,name:'Wiecej niż 50'},
	  			{id: 5,name:'Wiecej niż 100'},
	  			{id: 6,name:'Wiecej niż 150'},
	  			{id: 7,name:'Wiecej niż 200'},
	  			{id: 8,name:'Wiecej niż 300'},
	  			{id: 9,name:'Wiecej niż 500'},
	  			{id: 10,name:'Wiecej niż 1000'},
	  			]
	  		},
	  	},
	  	selected_filters:{
	  		masseur_note: 0,
	  		masseur_notes_count: 0,
	  		masseur_opinions_count: 0,
	  		city: '',
	  		to_masseur: false,
	  		to_client: false,

	  	},
	  	previous_filters: {}
	  }
	  
	},

	props: ['s_previous_filters'],

	components: {
	    'dropdown': dropdown,
	    'dropdown-search': dropdownsearch,
	},

	methods: {
	  changeMasseurNote(payload) {
	  		this.selected_filters.masseur_note  = payload.id;
	  },
	  changeMasseurNotesCount(payload) {
	  		this.selected_filters.masseur_notes_count  = payload.id;
	  },
	  changeMasseurOpinionsCount(payload){
	  	this.selected_filters.masseur_opinions_count = payload.id;
	  },
	  changeCity(payload){
	  	this.selected_filters.city = payload.name;
	  },

	  getSelectedMOC(){
	  	let options = this.filters.masseur_opinions_count;
	  	let selected = this.selected_filters.masseur_opinions_count;
  		for(var i=0; i<options.options.length;i++){
  			if(options.options[i].id == selected){
  				return options.options[i]
  			}
  		}
  		return options.options[0];
	  },

	  getSelectedMNC(){
	  	let options = this.filters.masseur_notes_count;
	  	let selected = this.selected_filters.masseur_notes_count;
  		for(var i=0; i<options.options.length;i++){
  			if(options.options[i].id == selected){
  				return options.options[i]
  			}
  		}
  		return options.options[0];
	  },

	  getSelectedMN(){
	  	let options = this.filters.masseur_note;
	  	let selected = this.selected_filters.masseur_note;
  		for(var i=0; i<options.options.length;i++){
  			if(options.options[i].id == selected){
  				return options.options[i]
  			}
  		}
  		return options.options[0];
	  }
	},

	created(){
		this.previous_filters=JSON.parse(this.s_previous_filters);
		if(this.previous_filters.city != undefined){
			this.selected_filters.city = this.previous_filters.city;
		}
		if(this.previous_filters.masseur_note != undefined){
			this.selected_filters.masseur_note = this.previous_filters.masseur_note;
		}
		if(this.previous_filters.masseur_notes_count != undefined){
			this.selected_filters.masseur_notes_count = this.previous_filters.masseur_notes_count;
		}
		if(this.previous_filters.masseur_opinions_count != undefined){
			this.selected_filters.masseur_opinions_count = this.previous_filters.masseur_opinions_count;
		}
		if(this.previous_filters.to_client != undefined){
			this.selected_filters.to_client = this.previous_filters.to_client;
		}
		if(this.previous_filters.to_masseur != undefined){
			this.selected_filters.to_masseur = this.previous_filters.to_masseur;
		}else{
			// this.selected_filters.to_masseur = true;
		}

	},

}
</script>