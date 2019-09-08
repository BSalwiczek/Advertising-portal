<template>
  <div>
  <div class="stars">
    <span class="nobreak"
    @click="save"
    @mouseover="nobreak = true"
    @mouseleave="nobreak = false"><i ref="star1" class="" :class="{[fullStar]:isFull(1),[halfStar]:isHalf(1),[emptyStar]:!isFull(1)&&!isHalf(1),star1:isHalf(1)}"
      @mousemove="hovered(...arguments,1)"></i><i :class="{[fullStar]:isFull(2),[halfStar]:isHalf(2),[emptyStar]:!isFull(2)&&!isHalf(2),star2:isHalf(2)}"
      @mousemove="hovered(...arguments,2)"></i><i :class="{[fullStar]:isFull(3),[halfStar]:isHalf(3),[emptyStar]:!isFull(3)&&!isHalf(3),star3:isHalf(3)}"
      @mousemove="hovered(...arguments,3)"></i><i :class="{[fullStar]:isFull(4),[halfStar]:isHalf(4),[emptyStar]:!isFull(4)&&!isHalf(4),star4:isHalf(4)}"
      @mousemove="hovered(...arguments,4)"></i><i :class="{[fullStar]:isFull(5),[halfStar]:isHalf(5),[emptyStar]:!isFull(5)&&!isHalf(5),star5:isHalf(5)}"
      @mousemove="hovered(...arguments,5)"></i>
    </span>

  </div>

  <!-- <label>

    <label class="cbx" for="cbx3"><span>
        <svg width="12px" height="10px" viewbox="0 0 12 10">
          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
        </svg></span><span>Cena</span>
    </label>
  </label> -->
  </div>

  <!-- <i class="fas fa-star"></i> -->
  <!-- <i class="fas fa-star-half-alt"></i> -->
</template>
<style scoped>
.stars{
  font-size: 5.3vh
}
.far:hover,.fas:hover{
  cursor: pointer
}
span i:not(:first-child){
  margin-left:10px;
}
.star1{
  margin:0 0.2vh;
}
.star2,.star3,.star4,.star5{
  margin-left: calc(10px + 0.2vh) !important;
  margin-right: 0.2vh;
}

.wave{
  animation: wave2 0.4s ease;
}
/* animation: wave 0.4s ease; */
@keyframes wave2 {
  50% {
    transform: scale(1.1);
  }
}

</style>
<script>
export default{
  data(){
    return{
      nobreak:false,
      stars: 0,
      saved:false,
      emptyStar: ['far fa-star'],
      fullStar: ['fas fa-star wave'],
      halfStar: ['fas fa-star-half-alt']
    }
  },
  watch:{
    nobreak(n,o){
      if(n==false && !this.saved)
        this.stars = 0;
    },
    stars(n,o){
      this.saved = false;
    }
  },
  methods:{
    hovered(event,x){
      if(event.clientX-this.$refs.star1.getBoundingClientRect().left < (x-1)*(this.$refs.star1.clientWidth+10)+(this.$refs.star1.clientWidth+1)/2)
      {
        this.stars = x-1+0.5;
        this.$emit('note-updated',this.stars)
      }else{
        this.stars = x;
        this.$emit('note-updated',this.stars)
      }

    },
    isFull(x){
      return this.stars>=x;
    },
    isHalf(x){
      return this.stars-x === -0.5;
    },
    save(){
      this.saved=true;
    }
  }
}
</script>
