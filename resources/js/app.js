/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


import VeeValidate, { Validator } from 'vee-validate';

const dict = {
	custom:{
		email:{
			required: 'Adres email jest wymagany',
			email: 'Podaj poprawny adres email',
		},
		name:{
			required: 'Imie jest wymagane',
			max: 'Imie może mieć maksymalnie 30 znaków',
			alpha: 'Imie może się składać wyłącznie z liter',
		},
		surname:{
			required: 'Nazwisko jest wymagane',
			max: 'Nazwisko może mieć maksymalnie 30 znaków',
			alpha: 'Nazwisko może się składać wyłącznie z liter',
		},
		password2:{
			is: 'Hasła muszą być identyczne',
			required: 'Potwierdzenie hasła jest wymagane'
		},
		password:{
			required: 'Hasło jest wymagane',
			min: 'Hasło musi się składać z co najmniej 8 znaków'
		},
		accept_terms:{
			required: 'Należy zaakceptować regulamin'
		},
		title:{
			required: 'Należy wpisać tytuł ogłoszenia'
		},
		description:{
			required: 'Należy opisać ogłoszenie'
		},
		where:{
			required: 'Zaznacz co najmniej jedno miejsce'
		},
		city:{
			required: 'Miejscowość jest wymagana'
		},
		province:{
			required: 'Województwo jest wymagane'
		},
		street:{
			required: 'Ulica jest wymagana'
		},
		area:{
			required: 'Obszar jest wymagany'
		},
		number:{
			required: 'Numer jest wymagany'
		},
		massageType:{
			required: 'Wpisz nazwę masażu'
		},
		massageDesc:{
			required: 'Wpisz opis masażu'
		},
		price:{
			required: 'Wpisz cenę',
			numeric: 'Cena musi być liczbą'
		},
		duration:{
			required: 'Podaj czas trwania masażu'
		},
		image:{
			image: 'Wysłany plik musi być zdjęciem'
		},
    opinion:{
      max: 'Twoja opinia jest za długa. Możesz wykorzystać maksymalnie 3000 znaków'
    },
    since:{
      required: 'To pole jest wymagane',
      max: 'Nie można przekroczyć 16 znaków'
    },
    to:{
      max: 'Nie można przekroczyć 16 znaków'
    },
    shortDescription:{
      required:'To pole jest wymagane',
      max: 'Nie można przekroczyć 255 znaków',
    },

	},
  messages:{
    max: (field, { length }) => `Przekroczyłeś maksymalną liczbę znaków`,
    required: 'To pole jest wymagane'
  }
};

Validator.localize('en', dict);

Vue.use(VeeValidate);

// *
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>


// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('register-component', require('./components/RegisterComponent.vue').default);
Vue.component('verify-component', require('./components/VerifyComponent.vue').default);
Vue.component('client-profile', require('./components/client/Profile.vue').default);
Vue.component('masseur-profile', require('./components/masseur/Profile/Profile.vue').default);
Vue.component('add-m-ad', require('./components/masseur/AddAdComponent.vue').default);
Vue.component('alert-success', require('./components/alerts/AlertSuccessComponent.vue').default);
Vue.component('massage-types-gallery', require('./components/masseur/MassageTypeGallery.vue').default);
Vue.component('show-ad', require('./components/masseur/ShowAdComponent.vue').default);
Vue.component('filter-ads', require('./components/FilterAdsComponent.vue').default);
Vue.component('slider', require('./components/NoUiSliderComponent.vue').default);
Vue.component('sort-ads', require('./components/SortAdsComponent.vue').default);
Vue.component('search-banner', require('./components/SearchBanner.vue').default);
Vue.component('listen-for-messages', require('./components/ListenForMessages.vue').default);
Vue.component('sidebar', require('./components/others/Sidebar.vue').default);
Vue.component('contact-button', require('./components/others/ContactButton.vue').default);
Vue.component('opinion', require('./components/masseur/Opinions/OpinionBox.vue').default);
Vue.component('passive-stars', require('./components/others/PassiveStars.vue').default);

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

// import vSelect from 'vue-select';
// Vue.component('v-select', vSelect);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
