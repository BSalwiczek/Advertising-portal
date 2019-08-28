<template>
<div class="chat p-3">
	<div v-for="index in 5" :key="index">
		
	<div class="message">
		<img src="/storage/avatars/default.png" class="rounded-circle avatar chat-avatar" style="float:left">
		<div style="float:left">
			<div class="ml-2 message-text">Witam</div>
			<div style="clear:both"></div>
			<span class="ml-2" style="font-size:0.7em;padding-left: 0.5rem ">2 godz temu</span>
		</div>
		<div style="clear:both"></div>
	</div>

	<div class="my-message mt-2">
		<div style="float:right" class="ml-2 message-text">Witam</div>
		<div style="clear:both"></div>
		<div style="float:right" class="ml-2 mt-2 message-text">Witam po raz 2</div>
		<div style="clear:both"></div>
		<span class="mt-2" style="float:right;font-size:0.7em;padding-left: 0.5rem ">2 godz temu</span>
		<div style="clear:both"></div>
	</div>
	</div>
</div>	
</template>
<style type="text/css" scoped>
	.chat-avatar{
	width: 4rem;
	height: 4rem;
}

.message>div>.message-text{
	background-color: #f1f1f1;
	padding: 1rem;
	border-radius: 20px;
/*	display: inline-block;*/
}


.my-message>.message-text{
	background-color: #f1f1f1;
	padding: 1rem;
	border-radius: 20px;
	width: auto;
}
</style>
<script type="text/javascript">
export default{
	data(){
		return{
			messages:{
				
			}
		}
	},
	methods:{
		addMessage(message){
			console.log(message);
		}
	}
}
</script>