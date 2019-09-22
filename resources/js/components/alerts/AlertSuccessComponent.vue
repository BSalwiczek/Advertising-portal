<style scoped>
@import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
</style>
<template>
	<transition enter-active-class="animated slideInUp fadeIn" leave-active-class="animated zoomOut fast">
	<div class="alert alert-success alert-dismissible" role="alert" v-if="show">
	  <span v-html="message"></span>
	  <button type="button" class="close" @click="closeAlert">
	    <span>&times;</span>
	  </button>
	</div>
	</transition>
</template>

<style scoped>
	.alert{
		position: fixed;
		bottom: 5%;
		right: 5%;
		max-width: 40%
	}

</style>

<script>
	export default{
		data(){
			return{
				show: false,
				startTimer: null,
				endTimer: null,
			}
		},
		methods:{
			closeAlert(){
				this.show = false;
			}
		},
		watch:{
			show: function(new_v){
				if(new_v == false){
					this.$emit('alert-closed');
				}
			},
			showNow(new_v){
				if(new_v)
				{
					clearTimeout(this.startTimer);
					clearTimeout(this.endTimer);

					this.startTimer = setTimeout(() => this.show = true, 300);
					this.endTimer = setTimeout(() => this.show = false, 15000);
				}
			}
		},
		props:{
			'message': String,
			'showNow': Boolean,
		},
		mounted(){
			if(this.showNow){
				this.startTimer = setTimeout(() => this.show = true, 300);
				this.endTimer = setTimeout(() => this.show = false, 15000);
			}

		}
	}
</script>
