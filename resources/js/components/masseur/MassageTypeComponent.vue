<style scoped>
@import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
</style>

<template>
	<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
		<div class="type row mt-4">
			<div class="col-lg-3 my-auto">
				<textarea type="text" class="form-control" style="font-size: 1.4em" name="" v-bind:value="type"></textarea>
			</div>
			<div class="col-lg-3">
				<img class="img-fluid" src="/storage/massage_types/classic.jpg">
			</div>
			<div class="col-lg-4 my-auto">
				<textarea class="form-control" placeholder="Tutaj zamieść krótki opis masażu..."></textarea>
			</div>
			<div class="col-lg-2 my-auto">
				<div class="row">
					<div class="col-md-7 my-auto p-0">
						<input type="text" class="form-control" name="" placeholder="cena">
					</div>
					<div class="col-md-5 my-auto">
						PLN
					</div>
				</div>
			</div>
			<div class="col-lg-1 mt-3 p-0 text-center" style="margin-left: -8.34%" v-cl>
				<i @click="$emit('delete-mtc')" class="fas fa-trash-alt trash shake"></i>
			</div>
		</div>
		
	</transition>
</template>

<style scoped>
	.type{
		width: 85%;
		margin: 1em auto;
		background-color: #E7F8FF;
		padding: 0 2em;
		padding-right: 0;
		border-left: 5px solid #53C5F7;
	}
	textarea,input{
		border-color:#53C5F7;
		background-color: #E7F8FF;
		border-width: 2px;
		padding:0.5em;
		box-shadow: none;
		font-size: 1.1em;
	}
	.trash{
		color: #333;
	}
	.trash:hover{
		color: red;
		cursor: pointer;
		animation: shake 0.2s; 
	}

	@keyframes shake {
	  0% { transform: translate(1px, 1px) rotate(0deg); }
	  20% { transform: translate(-3px, 0px) rotate(1deg); }
	  40% { transform: translate(1px, -1px) rotate(1deg); }
	  60% { transform: translate(-3px, 1px) rotate(0deg); }
	  80% { transform: translate(-1px, -1px) rotate(1deg); }
	  100% { transform: translate(1px, -2px) rotate(-1deg); }
	}

</style>

<script type="text/javascript">
	export default{
		props:{
			mtype: String
		},
		data(){
			return {
				type: this.mtype,
			}
		},
	}
</script>