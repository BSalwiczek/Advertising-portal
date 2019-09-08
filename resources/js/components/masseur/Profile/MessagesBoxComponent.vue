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
							<strong class="mx-auto" style="font-size: 1.3em">
								  <i class="fas fa-circle" style="font-size: 0.9em" :class="{active:friend.active,notactive:!friend.active}"></i></strong>
								 &nbsp; {{ friend.name }} {{ friend.surname }}
							<p v-if="friend.author_of_last_msg=='Ty'"><b>{{ friend.author_of_last_msg }}</b>: <span v-text="shortenIfTooLong(friend.last_msg,200)"></span></p>
							<p v-else><span :class="{bold:!friend.seen_at}" v-text="shortenIfTooLong(friend.last_msg,200)"></span></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 p-0" style="border-left:1px solid #eee;">
			<div class="text-center header" style="line-height: 40px;vertical-align: middle;">
				<span v-text="getChosenFriendName()"></span>
				&nbsp; <i class="fas fa-circle" :class="{active:isFriendActive(),notactive:!isFriendActive()}"></i>
			</div>

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

.active{
	color: #42b883;
}
.notactive{
	color: #ddd;
}

.bold{
	font-weight: bold;
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
    background: #CAEFFF !important;
}
.selecteduser:hover{
	background-color: #CAEFFF !important;
}

.user:hover{
	/* -webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.15);
    -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.15);
    box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.15); */
		background-color: #f9f9f9;
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
    z-index: 8;
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
import EventBus from '../../EventBus.vue';
export default{
	data(){
		return{
			messageText: '',
			friends:[],
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
		firstFriendId: Number,
		friendData: Array,
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
				response.data.forEach((el)=>{
					let idd = 0;
					let author = '';
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
						 author_of_last_msg: author,
						 seen_at: el.seen_at,
						 active: false,
					})
				});

				this.friends = this.friends.sort(function(a, b) {
				    a = new Date(a.last_msg_time);
				    b = new Date(b.last_msg_time);
				    return a>b ? -1 : a<b ? 1 : 0;
				});
				this.Loaded = true;

				if(this.firstFriendId>=0){
					this.addUser(this.friendData[0]);
				}
				else
					this.changeActiveConv(this.friends[0].id);

				//laravel Echo
				this.friends.forEach((el)=>{
					let channel = this.createChannelName(el.id,this.userData.id);

					this.channels.push(channel);
					Echo.join(channel)
					.listen('NewMessage', (e)=>{
						if(e.sender_id == this.chosenFriendId){
							this.gotWebsocketMessage(e);
						}
						this.setFriendMessage(e.message,e.sender_id);
					})

					let timer;
					Echo.join(channel)
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

					Echo.join(channel)
					.listenForWhisper('seen_last_msg',(e)=>{
						if(this.chosenFriendId == e.user_id)
							this.$refs.chatlog.seenLastMsg();
					})
					.joining((user)=>{
						for(const [index,el] of this.friends.entries())
						{
							if(el.id === user.id)
							{
								this.friends[index].active = true;
							}
						}
					})
					.leaving((user)=>{
						for(const [index,el] of this.friends.entries())
						{
							if(el.id === user.id)
							{
								this.friends[index].active = false;
							}
						}
						// axios.post('/save-last-activity').then((response)=>{});
					})
					.here((users)=>{
						for(const [index,el] of this.friends.entries())
						{
							if(users.length === 2){
								if(el.id === users[0].id || el.id === users[1].id)
								{
									this.friends[index].active = true;
								}
							}else{
								if(el.id === users[0].id)
								{
									this.friends[index].active = true;
								}
							}

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
			let channel_name = this.createChannelName(this.chosenFriendId,this.userData.id);
			Echo.join(channel_name).whisper('seen_last_msg', {
						user_id: this.userData.id
			});
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

			if(this.chosenFriendId != friend_id)
			{
				this.friends[0].seen_at = null
			}else{
				let current_datetime = new Date();
				let formatted_date = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();
				this.friends[0].seen_at = formatted_date;
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
				for(const [index,el] of this.friends.entries())
				{
					if(el.id === this.chosenFriendId)
					{
						if(el.seen_at === null)
						{
							let current_datetime = new Date()
							let formatted_date = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();
							this.friends[index].seen_at = formatted_date;
							let channel_name = this.createChannelName(this.chosenFriendId,this.userData.id);
							Echo.join(channel_name).whisper('seen_last_msg', {
										user_id: this.userData.id
							});
							EventBus.$emit('seen-message',this.chosenFriendId);
						}
						break;
					}
				}
				this.$refs.chatlog.getMessages(id);
			}
		},
		typed(){
			if(!this.typing){
				console.log('typed');
				this.typing = true;

				let channel_name = this.createChannelName(this.chosenFriendId,this.userData.id);

				// this.channels.forEach((el)=>{
					let channel = Echo.join(channel_name);
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


		},
		createChannelName(id1,id2){
			let channel_name = '';
			if(id1 < this.userData.id)
				channel_name = 'newmsg.'+String(id1)+'.'+String(id2);
			else
				channel_name = 'newmsg.'+String(id2)+'.'+String(id1);
			return channel_name
		},
		getChosenFriendName(){
			if(this.friends.length>0)
			{
				for(const [index,el] of this.friends.entries())
				{
					if(el.id === this.chosenFriendId)
					{
						return el.name+' '+el.surname;
					}
				}
			}
		},
		isFriendActive(friend_id = this.chosenFriendId){
			if(this.friends.length>0)
			{
				for(const [index,el] of this.friends.entries())
				{
					if(friend_id == el.id)
					{
						return this.friends[index].active;
					}
				}
			}

		},
		shortenIfTooLong(text,num){
      if(text.length>num)
      {
        return text.substring(0,num)+"...";
      }
      return text;
    }

	}
}
</script>
