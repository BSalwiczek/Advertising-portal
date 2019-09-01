<template>
	<div class="row p-0">
		<div class="col-md-6 m-0 p-0">
			<!-- <label>Wyszukaj użytkownika</label>
			<input type="text" name=""> -->
			<div class="text-center header">Znajdź użytkownika  <search-user v-on:updateOption="addUser" ></search-user></div>

			<div style="overflow-y: auto;overflow-x: hidden;max-height: 800px;padding:0">
				<transition leave-active-class="animated fadeOut fast">
						<loader v-if="!Loaded"></loader>
				</transition>
				<div class="user" :class="{selecteduser:friend.id==chosenFriendId}" v-for="(friend,index) in friends" :key="index" @click="changeActiveConv(friend.id)">
					<div class="row">
						<div class="col-lg-2">
							<img :src="getProfileImgUrl(friend.profile_img)" class="rounded-circle avatar">
						</div>
						<div class="col-lg-10 mt-lg-0 mt-4 p-lg-0 p-3">
							<strong class="mx-auto" style="font-size: 1.3em">{{ friend.name }} {{ friend.surname }}</strong>
							<p v-if="friend.author_of_last_msg=='Ty'"><b>{{ friend.author_of_last_msg }}</b>: {{ friend.last_msg }}</p>
							<p v-else>{{ friend.last_msg }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 p-0" style="border-left:1px solid #eee;">
			<div class="text-center header" style="line-height: 40px;vertical-align: middle;">Jan Kowalski</div>

			<chat-log :user-data="user" :friend-id="chosenFriendId" :friend-typing="friend_typing" ref="chatlog"></chat-log>

			<div class="p-2">
				<hr class="mb-0">
				<form @submit.prevent="sendMessage">
				<div class="row">
					<div class="col-sm-10 pl-4" style="display: flex;justify-content: center;flex-direction: column;text-align: center;">
						<label for="surname" class="inp" style="max-width: 100%">
					  	<input v-model="messageText" @input="typed()" type="text" class="better-input" placeholder=" " style="border-bottom-width: 1px">
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
		min-height: 90px;

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
import loadingComponent from '../../others/LoadingComponent.vue';
export default{
	data(){
		return{
			messageText: '',
			friends:[
				// {
				// 	id: 10,
				// 	name:'Jan',
				// 	surname:'Kowalski',
				// 	profile_img:'default.png',
				// 	last_msg:'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
				// 	author_of_last_msg:'Ty'
				// },
				// {
				// 	id: 11,
				// 	name:'Jan',
				// 	surname:'Kowalski',
				// 	profile_img:'default.png',
				// 	last_msg:'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
				// 	author_of_last_msg:'Ty'
				// }
			],
			chosenFriendId: 11,
			user: {},
			Loaded: false,
			typing: false,
			friend_typing: false,
			typing_num: 0,
			typing_prev_num: 0,
			channels: [],
		}
	},
	props:{
		userData: Object,
	},
	components:{
		'chat-log':chatlog,
		'search-user':searchuser,
		'loader': loadingComponent
	},
	mounted(){
		this.user = this.userData;
		this.getFriends();
	},
	methods:{
		getFriends(){
			axios.get('/getFriends').then((response)=>{
				console.log(response.data);
				response.data.forEach((el)=>{
					let idd = 0;
					let author = '';
					console.log(el.sender_id);
					if(el.sender_id == this.userData.id){
						idd = parseInt(el.receiver_id);
						author = 'Ty';
					}else{
						idd = parseInt(el.sender_id)
						author = el.name + ' ' + el.surname;
					};

					this.friends.push({
						 surname:el.surname,
						 name:el.name,
						 profile_img:el.profile_img,
						 id:idd,
						 last_msg: el.message,
						 last_msg_time: el.msg_created,
						 author_of_last_msg: author
					})
				});

				this.friends = this.friends.sort(function(a, b) {
				    a = new Date(a.last_msg_time);
				    b = new Date(b.last_msg_time);
				    return a>b ? -1 : a<b ? 1 : 0;
				});
				this.Loaded = true;

				this.changeActiveConv(this.friends[0].id);

				//laravel Echo
				this.friends.forEach((el)=>{
					let channel = ''
					if(el.id < this.userData.id){
						channel = 'newmsg.'+el.id+'.'+this.userData.id;
					}else{
						channel = 'newmsg.'+this.userData.id+'.'+el.id
					}
					this.channels.push(channel);
					console.log(channel);
					Echo.private(channel)
					.listen('NewMessage', (e)=>{
						if(e.sender_id == this.chosenFriendId){
							this.gotWebsocketMessage(e);
						}
						this.setFriendMessage(e.message,e.sender_id);
					})

					let timer;
					Echo.private(channel)
					.listenForWhisper('typing',(e)=>{
						if(e.user_id == this.chosenFriendId){
							this.friend_typing = true;
							this.typing_num++;
							setTimeout(()=>{
								if(this.typing_num==this.typing_prev_num){
									this.friend_typing = false;
								}
								this.typing_prev_num = this.typing_num;

								clearTimeout(timer);
								timer = setTimeout(()=>{
									if(this.typing_num==this.typing_prev_num){
										this.friend_typing = false;
									}
								},800);
							},1200);
						}
					})
				})


			}).catch((e)=>{
				console.log(e);
			});
		},
		sendMessage(){
			if(this.messageText !== '')
			{
				this.$refs.chatlog.addMessage(this.messageText);
				this.setFriendMessage(this.messageText,this.chosenFriendId,this.userData.id);
				this.messageText = '';
			}

		},
		gotWebsocketMessage(e){
			this.friend_typing = false;
			console.log(e.msg_created);
			this.$refs.chatlog.writeMessage(e.message,e.msg_created,e.sender_id);
		},
		setFriendMessage(message,friend_id,sender_id = null){
			let ind = 0;
			let friend = {};
			for(const [index,el] of this.friends.entries())
			{
				if(el.id === friend_id)
				{
					ind = index;
					friend = el;
				}
			}
			if(ind != 0){
				this.friends.splice(ind,1);
				this.friends.unshift(friend);
			}
			this.friends[0].last_msg = message;
			if(sender_id !== this.userData.id){
				this.friends[0].author_of_last_msg = this.friends[0].name + ' ' + this.friends[0].surname;
			}
			else{
				this.friends[0].author_of_last_msg = 'Ty';
			}
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
				this.$refs.chatlog.getMessages(data.id);
			}else{
				if(this.chosenFriendId !== data.id)
				{
					this.$refs.chatlog.getMessages(parseInt(data.id));
				}
				this.chosenFriendId = data.id;
			}

		},
		getProfileImgUrl(name){
			return '/storage/avatars/'+name;
		},
		changeActiveConv(id){
			if(id!=this.chosenFriendId){
				this.chosenFriendId = id;
				this.$refs.chatlog.getMessages(id);
			}
		},
		typed(){
			if(!this.typing){
				console.log('typed');
				this.typing = true;

				let channel_name = '';
				if(this.chosenFriendId < this.userData.id)
				{
					channel_name = 'newmsg.'+String(this.chosenFriendId)+'.'+String(this.userData.id)
				}else{
					channel_name = 'newmsg.'+String(this.userData.id)+'.'+String(this.chosenFriendId)
				}


				// this.channels.forEach((el)=>{
					let channel = Echo.private(channel_name);
					setTimeout(() => {
				    	channel.whisper('typing', {
				      typing: true,
							user_id: this.userData.id
				    });
					})
				// });
				setTimeout(()=>{
					this.typing = false;
				},700)
			}


		}
	}
}
</script>
