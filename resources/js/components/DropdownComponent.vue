<template>
    <div class="btn-group w-75">
        <li @click="toggleMenu()" ref="dropdownbutton" class="dropdown-toggle" v-if="selectedOption.name !== undefined" :class="{chosen: isChosen}">
          <span v-html="selectedOption.name"></span>
          <span class="caret"></span>
        </li>

        <li @click="toggleMenu()" ref="dropdownbutton" class="dropdown-toggle" v-if="selectedOption.name === undefined" :class="{chosen: isChosen}">
          {{placeholderText}}
          <span class="caret"></span>
        </li>



        <ul v-if="showMenu" class="dropdown-men" > <!-- class="dropdown-men"  -->
            <li v-for="option in options">
                <a href="javascript:void(0)" 
                @click="updateOption(option)" 
                v-closable="{
                    exclude: ['dropdownbutton'],
                    handler: 'onClose'
                  }">
                    <span v-html="option.name"></span>
                </a>
            </li>
        </ul>
    </div>
</template>

<style scoped>

.btn-group {
/*  min-width: 160px;*/
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
 /* min-width: 160px;*/
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

/*.dropdown-toggle::after{
  border:0;
}*/

.dropdown-men {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  float: left;
  /*min-width: 160px;*/
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

.chosen{
  background: #E2F6FF !important;
  border: none !important;
}

.chosen:hover{
  background-color: #E2F6FF !important;
}

li {
    list-style: none;
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
              id: 0,
              name: '',
            },
            showMenu: false,
            isChosen: false,
            placeholderText: 'Please select an item',
        }
    },
    props: {
        options: {
            type: [Array, Object]
        },
        selected: {},
        placeholder: [String]
    },

    mounted() {
        this.selectedOption = this.selected;
        if(this.selectedOption.id != 0){
          this.isChosen = true;
        }
        if (this.placeholder)
        {
            this.placeholderText = this.placeholder;
        }
    },

    methods: {
        updateOption(option) {
            if(option.id !=0 ){
              this.isChosen = true;
            }else{
              this.isChosen = false;
            }
            this.selectedOption = option;
            this.showMenu = false;
            this.$emit('updateOption', this.selectedOption);
        },

        toggleMenu() {
          this.showMenu = !this.showMenu;
        },

        onClose(){
          this.showMenu = false;
        }
    }
}
</script>
