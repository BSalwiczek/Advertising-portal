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
			required: 'Imie jest wymagane'
		},
		surname:{
			required: 'Nazwisko jest wymagane'
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
		}
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
Vue.component('add-m-ad', require('./components/masseur/AddAdComponent.vue').default);
Vue.component('alert-success', require('./components/alerts/AlertSuccessComponent.vue').default);
Vue.component('massage-types-gallery', require('./components/masseur/MassageTypeGallery.vue').default);
Vue.component('show-ad', require('./components/masseur/ShowAdComponent.vue').default);
Vue.component('filter-ads', require('./components/FilterAdsComponent.vue').default);

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