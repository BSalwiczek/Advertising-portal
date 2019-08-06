<template>
	<form method="get" action="/masazysci">

				<div class="filter-box mt-3 mb-5">
					<div class="row">
						<div class="col-md-2 col-sm-6">
							<span>Typ masażu</span><br>
						</div>
						<div class="col-md-2 col-sm-6">
							<span>Ocena masażsty</span><br>
							<dropdown :options="filters.masseur_note.options" 
							  :selected="filters.masseur_note.options[0]" 
							  v-on:updateOption="changeMasseurNote">
							</dropdown>
						</div>
						<div class="col-md-2 col-sm-6">
							<span>Ilość ocen</span><br>
							<dropdown :options="filters.masseur_notes_cout.options" 
							  :selected="filters.masseur_notes_cout.options[0]" 
							  v-on:updateOption="changeMasseurNote">
							</dropdown>
						</div>
						<div class="col-md-2 col-sm-6 mt-xs-3 mt-md-0">
							<span>Ilość opinii</span><br>
							<dropdown :options="filters.masseur_opinions_cout.options" 
							  :selected="filters.masseur_opinions_cout.options[0]" 
							  v-on:updateOption="changeMasseurNote">
							</dropdown>
						</div>
						<div class="col-md-2 col-sm-6 mt-xs-3 mt-md-0">
							<span>Miejscowość</span><br>
							<dropdown-search 
							  v-on:updateOption="changeMasseurNote">
							</dropdown-search>
						</div>
						<div class="col-md-2 col-sm-6 mt-xs-3 mt-md-0">
							<span>Województwo</span><br>
						</div>
					</div>
					<div class="row mt-3 mb-3">
						<div class="col-md-2 col-sm-6 mt-xs-3 mt-md-0">
							<span>Dojazd do klienta</span><br>
						</div>
						<div class="col-md-2 col-sm-6 mt-xs-3 mt-md-0">
							<span>U masażysty</span><br>
						</div>
					</div>
				</div>			
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
	  			selected: 0,
	  			options: [
	  			{id:0,name:'Wszystkie'},
	  			{id:1,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> i więcej'},
	  			{id:2,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i>  i więcej'},
	  			{id:3,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i>  i więcej'},
	  			{id:4,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i>  i więcej'},
	  			{id:5,name:'<i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i> <i class="fas fa-star" style="color: #F9DC5C"></i>  i więcej'},
	  			]
	  		},
	  		masseur_notes_cout:{
	  			select: 0,
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
	  		masseur_opinions_cout:{
	  			select: 0,
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
	  		}
	  	},
	  }
	},

	components: {
	    'dropdown': dropdown,
	    'dropdown-search': dropdownsearch,
	},

	methods: {
	  changeMasseurNote(payload) {
	  		this.filters.masseur_note.selected  = payload.id;
	  }
	}
}
</script>