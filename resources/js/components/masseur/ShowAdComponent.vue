<template>
	<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
	<div class="post mt-5" v-if="show">
		<h1>{{ ad.title }}</h1>
		<div class="row">
			<div class="col-sm-3"><span style="color:#09A2E5">Dodane przez: </span>{{ user.name }} {{ user.surname }}</div>
			<div class="col-sm-3"><i class="far fa-clock" style="margin-right: 3%;color:#09A2E5"></i>{{ ad.created_at }}</div>
			<div class="col-sm-6">
				<i class="fas fa-map-marker-alt" style="margin-right: 1%;color:#09A2E5"></i>
				<span v-if="isAreaSet()">{{ ad.area}}</span>
				<span v-else>{{ ad.city }}, ul. {{ ad.street }}</span>
			</span></div>
			<p class="post-description">
				{{ ad.description }}
			</p>
		</div>
		<div class="row">
			<div class="col-sm-3 offset-9">
				<a :href="adLink()" class="btn-slide-link"><button class="btn btn-first p-3">Dowiedz się więcej</button></a>
			</div>
		</div>
	</div>
	</transition>
</template>

<script type="text/javascript">
	export default{
		props: {
			s_ad: String,
			s_user: String,
			offset: String,
		},
		data(){
			return {
				user: {},
				ad: {},
				show: false
			}
		},
		methods: {
			isAreaSet(){
				return this.ad.area;
			},
			adLink(){
				return /masazysci/ +  this.ad.slug;
			},

		},
		mounted(){
			this.ad=JSON.parse(this.s_ad);
			this.user=JSON.parse(this.s_user);
			setTimeout(() => this.show = true, 50 + parseInt(this.offset)*100);
		},

	}
</script>