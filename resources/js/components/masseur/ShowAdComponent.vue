<template>
	<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
	<div class="post mb-5 p-0" v-if="show">
		<div class="row m-0">
			<div class="col-md-3 px-0">
				<div class="p-3 h-100" style="background-color:#F5FCFF;justify-content:center;">
					<div class="mt-3 d-flex" style="align-self: center;justify-content:center">
						<img :src="getProfileImgUrl(user.profile_img)" width="100" height="100" class="rounded-circle avatar">
					</div>
					<div class="mt-3 mb-3 text-center">
						<h5>{{ user.name }} {{ user.surname }}</h5>
						<div class="mb-2" style="font-size:0.9rem" v-if="!ad.avg_note"><i>Brak Opinii</i></div>
						<div v-else>
							<passive-stars :stars="parseFloat(ad.avg_note)"></passive-stars>
							{{ ad.avg_note }}/5 (Opinie: {{ ad.opinions_count }})
						</div>

						<!-- <div class="stars">
							<i class="fas fa-star-half-alt"></i>
							<i class="far fa-star"></i>
							<i class="far fa-star"></i>
							<i class="far fa-star"></i>
							<i class="far fa-star"></i>
						</div> -->

						<i class="fas fa-map-marker-alt" style="margin-right: 1%;color:#09A2E5"></i>
						<span v-if="isAreaSet()">{{ ad.area}}</span>
						<span v-else>{{ ad.city }}, ul. {{ ad.street }}</span>
					</div>
				</div>

			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-8 mt-5" style="align-self: center;">
						<h1 class="text-center">{{ ad.title }}</h1>
					</div>
					<div class="col-md-4">
						<div class="col-sm-12 price-box">
								Cena: {{ price }}
							</div>
					</div>
				</div>
				<p class="post-description  mt-3" v-text="ad.description"></p>
				<div class="row mb-3">
					<div class="col-sm-3 offset-9">
						<a :href="adLink()" class="btn-slide-link"><button class="btn btn-first p-3">Dowiedz się więcej</button></a>
					</div>
				</div>
			</div>
		</div>

		<!--  -->
	</div>
	</transition>
</template>

<style scoped>
.price-box{
	font-size: 1.5em;
	background-color: #FFFBEA;
	border-bottom-right-radius: 30px;
	border-bottom-left-radius: 30px;
	-webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.07);
	-moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.07);
	box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.07);
	padding: 0.6em;
	text-align: center;
}

</style>

<script type="text/javascript">
	export default{
		props: {
			s_ad: String,
			s_user: String,
			offset: String,
			s_massage_prices: String,
		},
		data(){
			return {
				user: {},
				ad: {},
				massage_prices: {},
				price: '',
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
			getProfileImgUrl(name){
				return '/storage/avatars/'+name;
			},

		},
		mounted(){
			this.ad=JSON.parse(this.s_ad);
			this.user=JSON.parse(this.s_user);
			this.massage_prices=JSON.parse(this.s_massage_prices);
			setTimeout(() => this.show = true, 50 + parseInt(this.offset)*100);

			var m_prices = []
			for(var i=0;i<this.massage_prices.length;i++){
				if(this.massage_prices[i][0] == this.ad.id){
					m_prices = this.massage_prices[i];
					break;
				}
			}
			if(m_prices.length == 2){
				this.price = String(m_prices[1])+" zł";
			}else if(m_prices.length > 2){
				let values = [];
				for(var i=1;i<m_prices.length;i++)
				{
					values.push(parseInt(m_prices[i]));
				}

				var max = Math.max.apply(null,values);
				var min = Math.min.apply(null,values);

				if(min == max){
					this.price=min;
				}else{
					this.price = "od "+min+" zł do "+max+" zł";
				}
			}


		},

	}
</script>
