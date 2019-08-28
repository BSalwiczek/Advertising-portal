<template>
	<div class="row p-0">

		<div class="col-md-6 m-0 p-0">
			<!-- <label>Wyszukaj użytkownika</label>
			<input type="text" name=""> -->
			<div class="text-center header" style="border-right: 10px solid #fdfdfd">Znajdź użytkownika  <search-user v-on:updateOption="addUser" ></search-user></div>

			<div style="overflow-y: auto;overflow-x: hidden;max-height: 800px;padding:0">
				<div class="user" :class="{selecteduser:friend.id==chosenFriendId}" v-for="(friend,index) in friends" :key="index" @click="changeActiveConv(friend.id)">
					<div class="row">
						<div class="col-lg-2">
							<img :src="getProfileImgUrl(friend.profile_img)" class="rounded-circle avatar">
						</div>
						<div class="col-lg-10 mt-lg-0 mt-4 p-lg-0 p-3">
							<strong class="mx-auto" style="font-size: 1.3em">{{ friend.name }} {{ friend.surname }}</strong>
							<p v-if="friend.author_of_last_msg=='Ty'">{{ friend.author_of_last_msg }}: {{ friend.last_msg }}</p>
							<p v-else>{{ friend.author_of_last_msg }} {{ friend.last_msg }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 p-0">
			<div class="text-center header">Jan Kowalski</div>

			<chat-log ref="chatlog"></chat-log>

			<div class="p-2">
				<hr class="mb-0">
				<form @submit.prevent="sendMessage">
				<div class="row">
					<div class="col-sm-10 pl-4" style="display: flex;justify-content: center;flex-direction: column;text-align: center;">
						<label for="surname" class="inp" style="max-width: 100%">
					  	<input v-model="messageText" type="text" class="better-input" placeholder=" " style="border-bottom-width: 1px">
					  	<span class="label"></span>
					  	<span class="border-b"></span>
						</label>
					</div>
					<div class="col-sm-2 pl-0 pt-2" style="display: flex;justify-content: center;flex-direction: column;text-align: center;">
						<button class="btn send-msg">Wyślij <i class="far fa-paper-plane" style="font-size: 1.1em"></i></button>
					</div>
				</div>
				</form>
			</div>
		</div>
		

	</div>
</template>

<style type="text/css" scoped>
.profile-img{
	border: 1px solid #eee;
}
.user{
	padding: 1em;
	border-bottom:1px solid #f1f1f1;
    transition: all 0.2s ease;
}
.avatar{
	width: 100%;
	height: auto;
	position:relative;
	z-index: 2
}
/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #AAA; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #888; 
}

.selecteduser{
    background: #CAEFFF;
}

.user:hover{
	-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.15);
    -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.15);
    box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.15);
    transition: all 0.2s ease;
    cursor: pointer;
}

.new-massage{
	outline: none;
	border:none;
	border-bottom: 1px solid #e8eaec;
}


.header{
-webkit-box-shadow: 0px 11px 12px -13px rgba(0,0,0,0.20);
-moz-box-shadow: 0px 11px 12px -13px rgba(0,0,0,0.20);
box-shadow: 0px 11px 12px -13px rgba(0,0,0,0.20);
    z-index: 30;
    position: relative;
    width: 100%;
    background-color:#f9f9f9;
    border-bottom:1px solid #f1f1f1;
    padding: 1.5rem 1rem;
}

.chat{
	overflow-y: auto;
	overflow-x: hidden;
	max-height: 700px;
}

.send-msg{
	background-color:#53C5F7;
	transition: all .2s;
	color: white;
}
.send-msg:hover{
	background-color: #7CD4FA;
	transition: all .2s;

}
</style>

<script type="text/javascript">
import chatlog from './ChatLog.vue';
import searchuser from './SearchUserComponent.vue';
export default{
	data(){
		return{
			messageText: 'dvwe',
			friends:[
				{
					id: 10,
					name:'Jan',
					surname:'Kowalski',
					profile_img:'default.png',
					last_msg:'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
					author_of_last_msg:'Ty'
				},
				{
					id: 11,
					name:'Jan',
					surname:'Kowalski',
					profile_img:'default.png',
					last_msg:'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
					author_of_last_msg:'Ty'
				}
			],
			chosenFriendId: 11
		}
	},
	components:{
		'chat-log':chatlog,
		'search-user':searchuser,
	},
	methods:{
		sendMessage(){
			this.$refs.chatlog.addMessage(this.messageText);
			this.messageText = '';
			
		},
		addUser(data){
			let exist = false;
			for(var f_id in this.friends){
				if(this.friends[f_id].id == data.id){
					exist = true;
					break;
				}
			}
			if(!exist){
				if(data.last_msg == null){
						data.last_msg = 'Rozpocznij konwersację'
				}
				this.friends.unshift(data);
				this.chosenFriendId = data.id;	
			}else{
				this.chosenFriendId = data.id;
			}
			
				
			
			
		},
		getProfileImgUrl(name){
			return '/storage/avatars/'+name;
		},
		changeActiveConv(id){
			if(id!=this.chosenFriendId){
				this.chosenFriendId = id;
			}
		}
	}
}
</script>