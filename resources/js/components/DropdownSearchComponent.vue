<template>
    <div class="btn-group">
        <li ref="dropdownbutton" class="dropdown-toggle no-outline" :class="{chosen: isChosen}">

          <input v-if="selectedOptionEmpty()" @input="userTyped()" class="dropdown-input" v-model="userInput" type="text"/>

          <span v-else>
            <span v-html="selectedOption.name"></span>
            <button class="remove-btn" @click="removeChosen()"><i class="far fa-times-circle"></i></button>
          </span>
        </li>

        <ul v-if="showMenu" class="dropdown-men" > <!-- class="dropdown-men"  -->
            <li class="text-center py-1" v-if="optionsEmpty() && !noResult" v-closable="{
                    exclude: ['dropdownbutton'],
                    handler: 'onClose'
                  }"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </li>
            <li v-if="noResult" class="text-center py-1" v-closable="{
                    exclude: ['dropdownbutton'],
                    handler: 'onClose'
                  }">
              Nie ma takiej miejscowości
            </li>
            <li v-else v-for="option in options">
                <a href="javascript:void(0)"
                @click="updateOption(option)"
                v-closable="{
                    exclude: ['dropdownbutton'],
                    handler: 'onClose'
                  }">
                  {{ option.name }}, woj. {{ option.province}}
                </a>
            </li>
        </ul>
    </div>
</template>

<style>

.dropdown-input{
  border:none;
  outline: none;
  box-shadow: none;
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
  margin: 10px 1px;
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
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  background-clip: padding-box;
}

.dropdown-men > li > a {
  padding: 10px 30px;
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

.chosen{
  background: #E2F6FF !important;
  border: none !important;
}

.chosen:hover{
  background-color: #E2F6FF !important;
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
            selectedOption: {
              id: -1,
              name: '',
              cityId: 0,
            },
            userInput: "",
            showMenu: false,
            isChosen: false,
            noResult: false,
            placeholderText: 'Please select an item',
            // options: [],
            options:[]
        }
    },
    props: {
        selected: {},
        placeholder: [String]
    },

    mounted() {
        if(this.selected != "")
          this.selectedOption = {id:0,name:this.selected,cityId:0};
        if (this.placeholder)
        {
            this.placeholderText = this.placeholder;
        }
    },

    methods: {
        updateOption(option) {
            this.selectedOption = option;
            this.showMenu = false;
            this.$emit('updateOption', this.selectedOption);
        },

        // toggleMenu() {
        //   this.showMenu = !this.showMenu;
        // },

        onClose(){
          this.showMenu = false;
        },

        selectedOptionEmpty(){
          if(this.selectedOption.id == -1){
            this.isChosen = false;
            return true;
          }
          else{
            this.isChosen = true;
            return false;
          }
        },

        optionsEmpty(){
          if(this.options.length == 0){
            return true;
          }else
            return false;
        },

        removeChosen(){
          this.selectedOption = {id:-1,name:'',cityId:0};
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
            axios.post('/getCities',{input:this.userInput}).then(response => {
              if(response.data == 0){
                this.noResult = true;
              }else{
                this.noResult = false;
                this.options = [];
                console.log(response.data);
                for(var city in response.data){
                  this.options.push({'id':city,'name':response.data[city].cityName,'province':response.data[city].provinceName.toLowerCase(),'cityId':response.data[city].cityId});
                }
              }

            }).catch((error)=>{
              console.log(error);
            })
          }else{
            this.noResult = false;
          }
        }
    },
}
</script>
