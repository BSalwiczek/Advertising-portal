<template>
	<div class="row" style="margin-top:7rem;margin-right: 0;margin-left: 0">
		<div class="col-md-8 offset-md-2">
			<div class="box-container pt-0 pb-0">
				<div class="row" style="margin-right: 0;margin-left: 0">
					<div class="col-md-2 col-xs-12 left-menu">
						<ul class="navbar-nav mt-5">
							<li class="left-menu-item" :class="{'item-active':(option==0)}" @click="ChangeOption(0)">Aktywność</li>
							<li class="left-menu-item" :class="{'item-active':(option==1)}" @click="ChangeOption(1)">Ustawienia konta</li>
							<li class="left-menu-item" :class="{'item-active':(option==2)}" @click="ChangeOption(2)">Zmiana hasła</li>
						</ul>
					</div>

					<div class="col-md-10 col-xs-12">
						<activity-component v-if="option==0"></activity-component>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</template>

<style scoped>

.left-menu{
	min-height: 500px;
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
import ActivityComponent from './ActivityComponent.vue'
    export default {
    	props:{
    		s_user: String,
		},
		data(){
			return{
				user:{},
    			option: 0

			}
		},
		components:{
			"activity-component":ActivityComponent
		},
		methods:{
	 		ChangeUserToObj() {
	 			this.user = JSON.parse(this.s_user);
	 		},
	 		ChangeOption(new_option){
	 			this.option = new_option;
	 		}
		},
		beforeMount(){
		   this.ChangeUserToObj();
		},
	}
 </script>