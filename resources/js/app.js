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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});