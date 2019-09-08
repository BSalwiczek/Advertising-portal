<template>
<div class="mt-3">
    <div class="box-container">
      <h5> Ostatnie opinie</h5>
      <span style="color:#09A2E5;">Wystawiono {{ total_opinions_count }} opinii</span>
    </div>

  <div class="row mx-0">
    <div class="col-lg-10">
      <transition-group enter-active-class="animated fadeIn">
        <div class="post mt-3 py-4 pl-5" v-for="(opinion,index) in opinions" :key="opinion.id">
          <div class="row">

            <div class="col-md-2 col-4 p-0">
              <img :src="getProfileImgUrl(opinion.profile_img)" class="avatar rounded-circle img-fluid"/>
            </div>
            <div class="col-md-10 col-8">
              <span style="font-size: 1.4rem" class="mr-3">{{ opinion.name }} {{ opinion.surname }}</span>
              <span class="stars" v-html="getStars(opinion.note)"></span><b style="font-size:1rem;margin-left:0.4rem"> {{ opinion.note }} / 5</b>
              <div class="mt-1">{{ opinion.opinion }}</div>
            </div>
          </div>
        </div>
      </transition-group>

    </div>

  </div>
  <paginator :pagination-data="paginationData" @go-to-page="getOpinions"></paginator>
</div>

</template>

<style scoped>
.avatar{
    max-height: 100px;
}
.box-container{
  width:auto;
  padding: 2% 5%;
  border-radius: 1000px;
  display: inline-block
}
</style>

<script>
import paginator from '../../others/Paginator.vue'
export default{
  data(){
    return{
      total_opinions_count: 0,
      paginationData:{
        current_page:0,
        last_page:0,
        from: 0,
        path: '',
      },
      opinions:[
        // {
        //   id: 0,
        //   name: 'Lolek',
        //   surname: 'Bolek',
        //   profile_img: 'default.png',
        //   note: 1.5,
        //   created_at: 'wczoraj',
        //   opinion: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. '
        // },
        // {
        //   id: 1,
        //   name: 'Lolek',
        //   surname: 'Bolek',
        //   profile_img: 'default.png',
        //   note: 2,
        //   created_at: 'wczoraj',
        //   opinion: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. '
        // },
        // {
        //   id: 2,
        //   name: 'Lolek',
        //   surname: 'Bolek',
        //   profile_img: 'default.png',
        //   note: 5,
        //   created_at: 'wczoraj',
        //   opinion: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. '
        // },
        // {
        //   id: 3,
        //   name: 'Lolek',
        //   surname: 'Bolek',
        //   profile_img: 'default.png',
        //   note: 4,
        //   created_at: 'wczoraj',
        //   opinion: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. '
        // },
        // {
        //   id: 4,
        //   name: 'Lolek',
        //   surname: 'Bolek',
        //   profile_img: 'default.png',
        //   note: 4.5,
        //   created_at: 'wczoraj',
        //   opinion: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. '
        // },

      ]
    }
  },
  props:{
    'postId':Number,
  },
  components:{
    'paginator':paginator,
  },
  mounted(){
    this.getOpinions(1);
  },
  methods:{
    getOpinions(page){
      console.log(this.postId);
      axios.get('/get-opinions?post_id='+this.postId+'&page='+String(page)).then((response)=>{
        this.opinions = [];
        console.log(response.data);
        this.total_opinions_count = response.data.pagination.total;
        response.data.data.data.forEach((el)=>{
          this.opinions.push({
            id: el.id,
            name: el.user.name,
            surname: el.user.surname,
            profile_img: el.user.profile_img,
            note: el.note,
            created_at: el.created_at,
            opinion: el.opinion,
          })
        })
        this.$set(this.paginationData, 'current_page', response.data.pagination.current_page);
        this.$set(this.paginationData, 'last_page', response.data.pagination.last_page);
        this.$set(this.paginationData, 'from', response.data.pagination.from);
        this.$set(this.paginationData, 'path', response.data.data.path+'?post_id='+this.postId);
        console.log(this.paginationData);
      })
    },
    getProfileImgUrl(name){
      return '/storage/avatars/'+name;
    },
    getStars(note){
      if(note==0) return '<i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>'
      if(note==0.5) return '<i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>'
      if(note==1) return '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>'
      if(note==1.5) return '<i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>'
      if(note==2) return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>'
      if(note==2.5) return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i>'
      if(note==3) return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>'
      if(note==3.5) return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i>'
      if(note==4) return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>'
      if(note==4.5) return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>'
      if(note==5) return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>'
    },
    addOpinion(data){
      console.log(data[0]);
      this.opinions.unshift({
        id: data[0].id,
        name: data[0].user.name,
        surname: data[0].user.surname,
        profile_img: data[0].user.profile_img,
        note: data[0].note,
        created_at: data[0].created_at,
        opinion: data[0].opinion,
      })
    }
  }
}
</script>
