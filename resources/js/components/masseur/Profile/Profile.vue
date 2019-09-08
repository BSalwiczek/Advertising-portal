<template>
	<div class="row" style="margin-top:7rem;margin-right: 0;margin-left: 0;z-index:5">
		<div class="col-lg-10 offset-lg-1">
			<div class="box-container pt-0 pb-0">
				<div class="row" style="margin-right: 0;margin-left: 0">
					<div class="col-md-3 col-xl-2 col-12 left-menu">
						<ul class="navbar-nav mt-5" style="margin-bottom: 6rem">
							<li class="left-menu-item" :class="{'item-active':(option==0)}" @click="ChangeOption(0)">Aktywność</li>
							<li class="left-menu-item" :class="{'item-active':(option==1)}" @click="ChangeOption(1)">Konwersacje</li>
							<li class="left-menu-item" :class="{'item-active':(option==2)}" @click="ChangeOption(2)">Edycja ogłoszenia</li>
							<li class="left-menu-item" :class="{'item-active':(option==3)}" @click="ChangeOption(3)">Ustawienia użytkownika</li>
							<li class="left-menu-item" :class="{'item-active':(option==4)}" @click="ChangeOption(4)">Terminarz</li>
							<li class="left-menu-item" :class="{'item-active':(option==5)}" @click="ChangeOption(5)">Ustawienia konta</li>
							<li class="left-menu-item" :class="{'item-active':(option==6)}" @click="ChangeOption(6)">Zmiana hasła</li>
						</ul>
					</div>

					<div class="col-md-9 col-xl-10 col-12">
						<message-box v-if="option==1" :first-friend-id="friendId" :user-data="user" :friend-data="friend"></message-box>
						<ad-settings v-if="option==2"></ad-settings>
						<user-settings v-if="option==3" :user-data="user" :csrf="csrf"></user-settings>
					</div>
				</div>
			</div>
		</div>
	</div>

</template>

<style scoped>

.left-menu{
	background-color: #f8fafc;
	border-right: 1px solid #e8eaec
}

.left-menu-item{
	padding: 1rem 0.3rem;
	padding-left: 1.5rem;
	transition: all 0.2s ease-out;
	border-bottom: 1px solid #e8eaec
}

.left-menu-item:hover::after{
	content: '>';
	margin-left: 5%;
	transition: all 0.8s ease-out;
}

.left-menu-item:hover
{
	margin-left: -2%;
	cursor: pointer;
	transition: all 0.2s ease-out;
}

.item-active{
	color:#53C5F7;
}

</style>

<script>
import AdSettings from './AdSettings.vue';
import UserSettings from './UserSettings.vue';
import MessageBox from './MessagesBoxComponent.vue';
    export default {
    	props:{
    		s_user: String,
    		csrf: String,
				firstOption: Number,
				messageFriendId: Number,
				s_friend_data: String,
		},
		data(){
			return{
				user:{},
  			option: 0,
				friendId: -1

			}
		},
		components:{
			"ad-settings":AdSettings,
			"user-settings":UserSettings,
			"message-box":MessageBox,

		},
		methods:{
	 		ChangeUserToObj() {
	 			this.user = JSON.parse(this.s_user);
	 		},
			ChangeFriendToObj() {
	 			this.friend = JSON.parse(this.s_friend_data);
	 		},
	 		ChangeOption(new_option){
	 			this.option = new_option;
	 		}
		},
		beforeMount(){
			this.ChangeUserToObj();
			this.ChangeFriendToObj();
			this.option = this.firstOption;
			this.friendId = this.messageFriendId;
		},
	}
 </script>
