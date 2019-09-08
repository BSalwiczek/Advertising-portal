<template>
<div class="d-block d-lg-none">
  <div class="overlay" @click="toggleNav()" :class="{active: isActive}"></div>
<div class="wrapper">
     <!-- Sidebar  -->
     <nav id="sidebar" :class="{active: isActive}" ref="sidebar">
         <div id="dismiss" @click="toggleNav()">
             <i class="fas fa-arrow-left"></i>
         </div>

         <!-- <div class="sidebar-header">
             <h3>Bootstrap Sidebar</h3>
         </div> -->

         <ul class="list-unstyled components mt-5" style="border:none">
             <li :class="{active:(site==0)}">
                 <a href="/"><i class="fas fa-home"></i> &nbsp;Strona główna</a>
             </li>
             <li :class="{active:(site==1)}">
                 <a href="/masazysci"><i class="fas fa-bullhorn"></i> &nbsp;Ogłoszenie masażystów</a>
                 <!-- <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
                 <ul class="collapse list-unstyled" id="pageSubmenu">
                     <li>
                         <a href="#">Page 1</a>
                     </li>
                     <li>
                         <a href="#">Page 2</a>
                     </li>
                     <li>
                         <a href="#">Page 3</a>
                     </li>
                 </ul> -->
             </li>
             <li :class="{active:(site==2)}">
               <a href="#"><i class="fas fa-bullhorn"></i> &nbsp;Ogłoszenia klientów</a>
             </li>
             <li :class="{active:(site==3)}">
                 <a href="#"><i class="far fa-comments"></i> &nbsp;Dyskusje</a>
             </li>

             <li style="background-color: #fff" v-if="Object.keys(userData).length>0" :class="{active:(site==4)}">
               <div class="d-flex justify-content-center pt-2 pb-2">
                   <h4 class="d-block float-left mr-3 mt-3" style="color:#5d5d5d">{{userData.name}}</h4>
                   <img :src="getProfileImgUrl(userData.profile_img)" width="60" height="60" class="rounded-circle avatar float-left">
                   <div style="clear:both"></div>
               </div>
             </li>
             <li v-if="Object.keys(userData).length>0">
               <listen-for-messages v-on:update-number="updateNumber(...arguments)" :csrf="csrf" :user-data="userData"></listen-for-messages>
             </li>
             <li style="background-color: #fff" v-if="Object.keys(userData).length>0">
               <a class="my-auto"><i style="color: #63326E" class="fas fa-bell"></i></a>
             </li>

             <li style="background: #7cd4fa" v-else :class="{active:(site==5)}">
               <a href="/register"><i class="fas fa-sign-in-alt"></i> &nbsp;Zarejestruj się</a>
               <a href="/login"><i class="fas fa-sign-in-alt"></i> &nbsp;Zaloguj się</a>
             </li>

         </ul>
     </nav>

     <!-- Page Content  -->
     <button type="button" id="sidebarCollapse" @click="toggleNav()" class="btn btn-toggle">
         <i class="fas fa-align-left"><span v-if="number>0" class="num-in-circle-1">{{ number }}</span></i>
         <span></span>
     </button>

 </div>


</div>
</template>

<style scoped>
a,
a:hover,
a:focus {
    color: inherit;
    text-decoration: none;
    transition: all 0.3s;
}

.navbar {
    padding: 15px 10px;
    /* background: #fff; */
    border: none;
    border-radius: 0;
    margin-bottom: 40px;
    box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}

.num-in-circle-1{
  background-color: #F9DC5C;
  display: inline-block;
  border-radius: 1000px;
  position:relative;
  padding: 0.15rem 0.30rem;
  font-size: 0.6rem;
  left: -6px;
  top: -10px;
  color: #013A52 !important;
}
/* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

.wrapper{
  background-color: #53C6F7;
}

#sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: -250px;
    height: 100vh;
    z-index: 999;
    background: #53C6F7;
    color: #fff;
    transition: all 0.3s;
    overflow-y: auto;
    overflow-x: hidden;
    box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
}

#sidebar.active {
    left: 0;
}

#dismiss {
    width: 35px;
    height: 35px;
    line-height: 35px;
    text-align: center;
    background: #53C6F7;
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    -webkit-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
}

#dismiss:hover {
    background: #fff;
    color: #53C6F7;
}

.overlay {
    display: none;
    position: fixed;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.7);
    z-index: 998;
    opacity: 0;
    transition: all 0.5s ease-in-out;
}
.overlay.active {
    display: block;
    opacity: 1;
}

#sidebar .sidebar-header {
    padding: 20px;
    background: #6d7fcc;
}

#sidebar ul.components {
    padding: 20px 0;
}

#sidebar ul p {
    color: #fff;
    padding: 10px;
}

#sidebar ul li a {
    padding: 10px;
    font-size: 1.1em;
    display: block;
}

#sidebar ul li a:hover {
    color: #53C6F7;
    /* background: #fff; */
}

#sidebar ul li.active>a,
a[aria-expanded="true"] {
    color: #53C6F7;
    background: #fff;
}

a[data-toggle="collapse"] {
    position: relative;
}


ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: #6d7fcc;
}

a.download {
    background: #fff;
    color: #7386D5;
}

/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #2cb6f2;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #7cd4fa;
}

</style>

<script>
import ListenForMessages from '../ListenForMessages.vue';
export default{
  data(){
    return{
      isActive: false,
      site: 0,
      number: 0,
    }
  },
  components:{
    'listen-for-messages':ListenForMessages,
  },
  props:{
    'csrf':String,
    'userData':Object,
  },
  mounted(){

  },
  methods:{
    toggleNav(){
      this.isActive = !this.isActive;
    },
    getProfileImgUrl(name){
      return '/storage/avatars/'+name;
    },
    updateNumber(x){
      this.number = x;
    }
  }
}
</script>
