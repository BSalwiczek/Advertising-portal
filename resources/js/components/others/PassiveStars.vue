<template>
  <div class="stars">
    <span class="nobreak"><i ref="star1" class="" :class="{[fullStar]:isFull(1),[halfStar]:isHalf(1),[emptyStar]:!isFull(1)&&!isHalf(1),star1:isHalf(1)}"
      ></i><i :class="{[fullStar]:isFull(2),[halfStar]:isHalf(2),[emptyStar]:!isFull(2)&&!isHalf(2),star2:isHalf(2)}"
      ></i><i :class="{[fullStar]:isFull(3),[halfStar]:isHalf(3),[emptyStar]:!isFull(3)&&!isHalf(3),star3:isHalf(3)}"
      ></i><i :class="{[fullStar]:isFull(4),[halfStar]:isHalf(4),[emptyStar]:!isFull(4)&&!isHalf(4),star4:isHalf(4)}"
      ></i><i :class="{[fullStar]:isFull(5),[halfStar]:isHalf(5),[emptyStar]:!isFull(5)&&!isHalf(5),star5:isHalf(5)}"
      ></i>
    </span>
  </div>
</template>

<style>
span i:not(:first-child){
  margin-left:4px;
}
.star1{
  margin:0 0.12vh;
}
.star2,.star3,.star4,.star5{
  margin-left: calc(4px + 0.12vh) !important;
  margin-right: 0.1vh;
}

</style>

<script>
export default{
  data(){
    return{
      emptyStar: ['far fa-star'],
      fullStar: ['fas fa-star wave'],
      halfStar: ['fas fa-star-half-alt']
    }
  },
  props:{
    'stars':Number,
  },
  methods:{
    isFull(x){
      return this.stars>=x;
    },
    isHalf(x){
      return this.stars-x === -0.5;
    },
  }
}
</script>
