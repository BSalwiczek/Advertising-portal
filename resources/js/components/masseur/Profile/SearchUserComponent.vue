<template>
    <div class="btn-group">
        <li ref="dropdownbutton" class="dropdown-toggle no-outline">

          <input @input="userTyped()" class="dropdown-input" v-model="userInput" type="text"/>
          <span><i class="fas fa-search" style="font-size:1.3em;opacity:.5"></i></span>
<!--           <span v-else>
            <span v-html="selectedUser.name"></span>
            <button class="remove-btn" @click="removeChosen()"><i class="far fa-times-circle"></i></button>
          </span> -->
        </li>

        <ul v-if="showMenu" class="dropdown-men"> <!-- class="dropdown-men"  -->
            <li class="text-center py-1" v-if="usersEmpty() && !noResult" v-closable="{
                    exclude: ['dropdownbutton'],
                    handler: 'onClose'
                  }"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </li>
            <li v-if="noResult" class="text-center py-1" v-closable="{
                    exclude: ['dropdownbutton'],
                    handler: 'onClose'
                  }">
              Nie ma takiego użytkownika
            </li>
            <li v-else v-for="user in users">
                <a href="javascript:void(0)" 
                @click="updateOption(user)" 
                v-closable="{
                    exclude: ['dropdownbutton'],
                    handler: 'onClose'
                  }">
                  <img :src="getImgSrc(user.profile_img)" class="mr-2 rounded-circle avatar" width="50" height="50"> {{ user.name }} {{ user.surname}}
                </a>
            </li>
        </ul>
    </div>
</template>

<style scoped>

.dropdown-input{
  border:none;
  outline: none;
  box-shadow: none;
  background-color: transparent;
}
.dropdown-input:hover{
  border:none;
  border:none;
  outline: none;
  box-shadow: none;
}

.btn-group {
 /* min-width: 160px;*/
  height: 40px;
  position: relative;
  margin: 0px 1px;
  display: inline-block;
  vertical-align: middle;
}
.btn-group a:hover {
  text-decoration: none;
}

.dropdown-toggle {
  color: #636b6f;
  /*min-width: 160px;*/
  padding: 10px;
  text-transform: none;
  font-weight: 300;
  margin-bottom: 7px;
  border: 0;
  background-image: linear-gradient(#009688, #009688), linear-gradient(#D2D2D2, #D2D2D2);
  background-size: 0 2px, 100% 1px;
  background-repeat: no-repeat;
  background-position: center bottom, center calc(100% - 1px);
  background-color: transparent;
  transition: background 0s ease-out;
  float: none;
  box-shadow: none;
  border-radius: 0;
}
.dropdown-toggle:hover {
  background: #eee;
  cursor: pointer;
}

.dropdown-toggle::after{
  border:0;
}

.no-outline:hover{  background-image: linear-gradient(#009688, #009688), linear-gradient(#D2D2D2, #D2D2D2);
  background-size: 0 2px, 100% 1px;
  background-repeat: no-repeat;
  background-position: center bottom, center calc(100% - 1px);
  background-color: transparent;
}

.dropdown-men {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  float: left;
  min-width: 100%;
  padding: 5px 0;
  margin: 2px 0 0;
  list-style: none;
  font-size: 14px;
  text-align: left;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  background-clip: padding-box;
  overflow-y: auto;
  overflow-x: hidden;
  max-height: 700px;
}

.dropdown-men > li > a {
  padding: 10px 15px;
  display: block;
  clear: both;
  font-weight: normal;
  line-height: 1.6;
  color: #333333;
  white-space: nowrap;
  text-decoration: none;
}
.dropdown-men > li > a:hover {
  background: #eee;
  color: #53C5F7;
}

.dropdown-men > li {
  overflow: hidden;
  width: 100%;
  position: relative;
  margin: 0;
}

.caret {
  display: relative;
  width: 0;
  position: relative;
  top: 10px;
  height: 0;
  margin-left: 2px;
  vertical-align: middle;
  border-top: 4px dashed;
  border-top: 4px solid \9;
  border-right: 4px solid transparent;
  border-left: 4px solid transparent;
  float: right;
}

.remove-btn:active,.remove-btn:focus,.remove-btn{
  color: red;
  float:right;
  background: transparent;
  box-shadow: none;
  border:none;
  outline: inherit;
  transition: all .2s;
}


.remove-btn:hover{
  ;
}

li {
    list-style: none;
}


/* loading */
.lds-spinner {
  display: inline-block;
  position: relative;
  width: 32px;
  height: 32px;
  line-height: 100px;
  vertical-align: middle;
}
.lds-spinner div {
  transform-origin: 16px 16px;
  animation: lds-spinner 1.2s linear infinite;
}
.lds-spinner div:after {
  content: " ";
  display: block;
  position: absolute;
  top: 1px;
  left: 14px;
  width: 2.5px;
  height: 7px;
  border-radius: 20%;
  background: #222;
}
.lds-spinner div:nth-child(1) {
  transform: rotate(0deg);
  animation-delay: -1.1s;
}
.lds-spinner div:nth-child(2) {
  transform: rotate(30deg);
  animation-delay: -1s;
}
.lds-spinner div:nth-child(3) {
  transform: rotate(60deg);
  animation-delay: -0.9s;
}
.lds-spinner div:nth-child(4) {
  transform: rotate(90deg);
  animation-delay: -0.8s;
}
.lds-spinner div:nth-child(5) {
  transform: rotate(120deg);
  animation-delay: -0.7s;
}
.lds-spinner div:nth-child(6) {
  transform: rotate(150deg);
  animation-delay: -0.6s;
}
.lds-spinner div:nth-child(7) {
  transform: rotate(180deg);
  animation-delay: -0.5s;
}
.lds-spinner div:nth-child(8) {
  transform: rotate(210deg);
  animation-delay: -0.4s;
}
.lds-spinner div:nth-child(9) {
  transform: rotate(240deg);
  animation-delay: -0.3s;
}
.lds-spinner div:nth-child(10) {
  transform: rotate(270deg);
  animation-delay: -0.2s;
}
.lds-spinner div:nth-child(11) {
  transform: rotate(300deg);
  animation-delay: -0.1s;
}
.lds-spinner div:nth-child(12) {
  transform: rotate(330deg);
  animation-delay: 0s;
}
@keyframes lds-spinner {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
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
  background: #AAA; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #888; 
}

</style>


<script>
import Vue from 'vue'
// This variable will hold the reference to
// document's click handler
let handleOutsideClick
Vue.directive('closable', {
  bind (el, binding, vnode) {
    // Here's the click/touchstart handler
    // (it is registered below)
    handleOutsideClick = (e) => {
      e.stopPropagation()
      // Get the handler method name and the exclude array
      // from the object used in v-closable
      const { handler, exclude } = binding.value
      // This variable indicates if the clicked element is excluded
      let clickedOnExcludedEl = false
      exclude.forEach(refName => {
        // We only run this code if we haven't detected
        // any excluded element yet
        if (!clickedOnExcludedEl) {
          // Get the element using the reference name
          const excludedEl = vnode.context.$refs[refName]
          // See if this excluded element
          // is the same element the user just clicked on
          clickedOnExcludedEl = excludedEl.contains(e.target)
        }
      })
      // We check to see if the clicked element is not
      // the dialog element and not excluded
      if (!el.contains(e.target) && !clickedOnExcludedEl) {
        // If the clicked element is outside the dialog
        // and not the button, then call the outside-click handler
        // from the same component this directive is used in
        vnode.context[handler]()
      }
    }
    // Register click/touchstart event listeners on the whole page
    document.addEventListener('click', handleOutsideClick)
    document.addEventListener('touchstart', handleOutsideClick)
  },
  unbind () {
    // If the element that has v-closable is removed, then
    // unbind click/touchstart listeners from the whole page
    document.removeEventListener('click', handleOutsideClick)
    document.removeEventListener('touchstart', handleOutsideClick)
  }
})
export default {
    data() {
        return {
            selectedUser: {
              id: -1,
              name: '',
              surname: '',
              profile_img: '',
            },
            userInput: "",
            showMenu: false,
            noResult: false,
            placeholderText: 'Please select an item',
            // users: [],
            users:[]
        }
    },
    props: {
        selected: {},
        placeholder: [String]
    },

    mounted() {
        if(this.selected != "")
          this.selectedUser = {id:0,name:this.selected,cityId:0};
        if (this.placeholder)
        {
            this.placeholderText = this.placeholder;
        }
    },

    methods: {
        updateOption(option) {
            this.selectedUser = option;
            this.showMenu = false;
            this.$emit('updateOption', this.selectedUser);
        },

        // toggleMenu() {
        //   this.showMenu = !this.showMenu;
        // },

        onClose(){
          this.showMenu = false;
        },

        // selectedUserEmpty(){
        //   if(this.selectedUser.id == -1){
        //     this.isChosen = false;
        //     return true;
        //   }
        //   else{
        //     this.isChosen = true;
        //     return false;
        //   }
        // },

        usersEmpty(){
          if(this.users.length == 0){
            return true;
          }else
            return false;
        },

        removeChosen(){
          this.selectedUser = {id:-1,name:'',cityId:0};
          let option={
              id: -1,
              name: '',
              cityId: 0,
            }
          this.updateOption(option);
        },

        userTyped(){
          this.showMenu = true;
          if(this.userInput.length > 2){
            axios.post('/getUsers',{input:this.userInput}).then(response => {
              if(response.data == 0){
                this.noResult = true;
              }else{
                this.noResult = false;
                this.users = [];
                let that = this;
                // console.log(response.data);
                response.data.forEach(el => {
                 that.users.push({'id':el.id,'name':el.name,'surname':el.surname,'profile_img':el.profile_img});
                })  
              }
              
            }).catch((error)=>{
              console.log(error);
            })
          }else{
            this.noResult = false;
          }
        },
        getImgSrc(name){
          return '/storage/avatars/'+name;
        }
    }
}
</script>
