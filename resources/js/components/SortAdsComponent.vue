<template>
<div class="d-flex justify-content-end" style="font-size: 0.9em">
	<span class="mr-2 my-auto">Sortuj</span>
	<dropdown-sort :options="sort.options"
	:selected="getSelected()"
	v-on:updateOption="changeSort"></dropdown-sort> 

</div>	
</template>

<style type="text/css" scoped>
</style>

<script type="text/javascript">
import dropdownsort from './DropdownSortComponent.vue';
export default {
	data(){
		return {
			sort: {
	  			options: [
	  			{id:0,name:'<i class="far fa-clock"></i> &nbsp; Data dodania (od najpóźniejszej)'},
	  			{id:1,name:'<i class="far fa-clock"></i> &nbsp; Data dodania (od najwcześniejszej)'},
	  			{id:2,name:'<i class="fas fa-dollar-sign"></i> &nbsp; Cena minimalna (od najtańszych)'},
	  			{id:3,name:'<i class="fas fa-dollar-sign"></i> &nbsp; Cena maksymalna (od najdroższych)'},
	  			{id:4,name:'<i class="fas fa-comments"></i> &nbsp; Opinie (od największej ilości)'},
	  			{id:5,name:'<i class="fas fa-star"></i> &nbsp; Ocena (od najlepszej)'},
	  			]
	  		},
	  		previous_sorting: 0
		}
	},
	components:{
		'dropdown-sort': dropdownsort,
	},
	props: ['s_previous_sorting'],
	methods:{
		changeSort(payload){
			this.$parent.$refs.filter.$refs.sortInput.value = payload.id;
			this.$parent.$refs.filter.$refs.filterForm.submit();
		},
		getSelected(){
			return this.sort.options[this.previous_sorting];
		}
	},
	created: function(){
		let previous_filters=JSON.parse(this.s_previous_sorting);
		if(previous_filters.sorting != null){
			this.previous_sorting = previous_filters.sorting;

		}
		
		this.$parent.$refs.filter.$refs.sortInput.value = this.previous_sorting;
		
	}
}
</script>