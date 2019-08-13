<template>
	<div style="width: 100%" class="mt-3" >
	</div>
</template>

<style type="text/css" scoped>
	@import '~nouislider/distribute/nouislider.css';
</style>

<style type="text/css">
	.noUi-connect{
		background: #53C5F7 !important;
	}
	.enabled{

	}
</style>

<script type="text/javascript">
import noUiSlider from 'nouislider/distribute/nouislider'
	export default {
		data(){
			return {
				dom: '',
			}
		},
		props: ['enabled','fromprice','toprice'],
		mounted: function(){
			noUiSlider.create(this.$el,{
		    connect: true,
		    behaviour: 'drag-tap',
		    start: [0, 500],
		    range: {
		    	'min': [0],
		        'max': [1000]
		    },
		    step: 1,
		    format: {
		    from: function(value) {
		            return parseInt(value);
		        },
		    to: function(value) {
		            return parseInt(value);
		        }
		    }

		   })

			if(this.enabled == false){
				this.$el.setAttribute('disabled', true);
			}
			this.$el.noUiSlider.set([parseInt(this.fromprice),parseInt(this.toprice)]);

			var self = this;
			this.$el.noUiSlider.on('slide', function (data) {
				self.$emit('update-data',data);
			});
		},
		watch:{
			enabled: function(new_v,old_v){
				if(new_v == true){
					this.$el.removeAttribute('disabled');
					
				}else{
					this.$el.setAttribute('disabled', true);
				}
			},
			// fromprice: function(new_v,old_v){
			// 	this.$el.noUiSlider.set([parseInt(new_v),parseInt(this.toprice)]);
			// },
			// toprice: function(new_v,old_v){
			// 	this.$el.noUiSlider.set([parseInt(this.fromprice),parseInt(new_v)]);
			// }
		}
	}
</script>