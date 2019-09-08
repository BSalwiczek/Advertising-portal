<template>
  <div v-if="paginationData.last_page != paginationData.from">
    <ul class="pagination mt-5 text-center" role="navigation">
        <div class="mx-auto">

            <li v-if="paginationData.from != paginationData.current_page" class="page-item d-inline-block">
                <a class="page-link" @click="gotopage(paginationData.current_page-1)" rel="prev" ><i class="fas fa-long-arrow-alt-left"></i></a>
            </li>





            <li v-if="paginationData.current_page < paginationData.last_page" class="page-item d-inline-block">
                <a class="page-link" @click="gotopage(paginationData.current_page+1)" rel="next"><i class="fas fa-long-arrow-alt-right"></i></a>
            </li>
        </div>
    </ul>
  </div>

</template>

<style scoped>
.page-link{
  color: #42b883 !important;
}
.page-link:hover{
  cursor: pointer;
}
</style>

<script>
export default{
  data(){
    return{
      show: false,
    }
  },
  props:{
    'paginationData': Object,
  },
  mounted(){
    console.log(this.paginationData);
  },
  methods:{
    gotopage(page){
      console.log(page);
      this.$emit('go-to-page',page);
    }
  }
}
</script>
