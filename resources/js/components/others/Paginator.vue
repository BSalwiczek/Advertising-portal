<template>
  <div v-if="paginationData.last_page != paginationData.from">
    <ul class="pagination mt-5 text-center" role="navigation">
        <div class="mx-auto">

            <li v-if="paginationData.from != paginationData.current_page" class="page-item d-inline-block">
                <a class="page-link" @click="gotopage(paginationData.current_page-1)" rel="prev" ><i class="fas fa-long-arrow-alt-left"></i></a>
            </li>

            <li v-for="(page,index) in pages" :key="index" class="page-item d-inline-block">
              <a class="page-link" @click="gotopage(page)">{{page}}</a>
            </li>

            <!-- <li class="page-item d-inline-block disabled" aria-disabled="true"><span class="page-link">...</span></li> -->



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
      pages: [1],
    }
  },
  props:{
    'paginationData': Object,
  },
  mounted(){
    // this.updatePaginator();
  },
  methods:{
    gotopage(page){

      if(page != '...'){
        console.log(page);
        this.$emit('go-to-page',page);
        this.updatePaginator();
      }

    },
    updatePaginator(){
      this.pages = [];

      let from = this.paginationData.from;
      let current = this.paginationData.current_page;
      let last = this.paginationData.last_page;

      if(last<=5)
      {
        this.pages.push(1);
        this.pages.push(2);
        this.pages.push(3);
        this.pages.push(4);
        this.pages.push(5);
      }else{
        this.pages.push(from);
        if(current-1>from)
        {
          if(current-2!==from && current-3!==from)
            this.pages.push('...');
          if(current-3==from)
            this.pages.push(current-2);
          this.pages.push(current-1);

        }
        if(current != from && current != last)
        {
          this.pages.push(current);
        }

        if(current+1<last)
        {
          this.pages.push(current+1);
          if(current+2!==last && current+3!==last)
            this.pages.push('...');
          if(current+3==last)
            this.pages.push(current+2);
        }
        this.pages.push(last);
      }

    }
  }
}
</script>
