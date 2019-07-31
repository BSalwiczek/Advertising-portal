<template>
  <div>
	<carousel :per-page="3" :autoplay="true" :autoplayTimeout="10000" :loop="true" :centerMode="true" :navigationEnabled="true" paginationActiveColor="#5d5d5d" :navigation-next-label="navigationNext" :navigation-prev-label="navigationPrev" :navigationClickTargetSize="5" >
  <slide v-for="(item,index) in mdata" v-bind:key="index">
    <div class="type mx-3">
      <h3 class="my-4 px-3">{{ item.name }}</h3>

      <!-- <img class="img-fluid" src="/storage/massage_types/classic.jpg"> -->
      <div>
        <div class="img-container">
          <img class="img-fluid d-flex" :src="imgUrl(index)">
        </div>

      </div>
      

      <p class="mt-3 px-3" style="font-size: 1.3em">{{ item.description }}</p>


      <div class="mt-4 text-center" style="font-size: 1.3em">
          <span style="mr-4">{{ item.price }}</span><span>PLN</span>
      </div>

      <div class="mt-4 text-center" style="font-size: 1.1em">
          <span style="mr-4">czas trwania: {{ item.duration }}</span>
      </div>
    
    </div>
  </slide>
</carousel>
</div>

</template>

<style scoped>
.type{
  background-color: #F5FCFF;
  padding: 2em 0;
  padding-top: 0.7em;
  border-top: 5px solid #53C5F7;
  -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.12);
  -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.12);
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.12);
}
textarea,input{
  border-color: #F5FCFF;
  background-color: #F5FCFF;
  border-width: 1px;
  padding:0.5em;
  box-shadow: none;
  outline: none;
  font-size: 1.1em;
  resize: none;
  text-align: center;
}
.img-container {
    display: inline-block;
    position: relative;
}
.positioning{
    position: absolute;
    font-size: 1.5em;
  top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ddd;
    opacity: 0.4;
    transition: all 0.2s;
    width: 100%;
    height: 100%;
    text-align: center;
}
.positioning:hover{
  opacity: 0.6;
  cursor: pointer;
  font-size: 1.9em;
  transition: all 0.2s;
}
.upload{
    position: absolute;
  top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}


</style>

<script type="text/javascript">
import { Carousel, Slide } from 'vue-carousel';

export default {
  components: {
    Carousel,
    Slide
  },
  props:['msgTypes'],
  data(){
    return {
      mdata: {},
    }
  },
  created(){
    this.mdata = JSON.parse(this.msgTypes);
  },
  methods: {
    imgUrl($id){
      return '/storage/'+this.mdata[$id].img_name.substring(7);
    }
  },
   computed: {
    navigationNext: function() { return `<div><i class="fas fa-chevron-right" style="color:#5d5d5d"></i></div>` },
    navigationPrev: function() { return `<div><i class="fas fa-chevron-left" style="color:#5d5d5d"></i></div>` },
  }

};
</script>