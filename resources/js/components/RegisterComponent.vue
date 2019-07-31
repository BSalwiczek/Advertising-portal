<style scoped>
@import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
</style>
<template>
    <div class="container auth-container mt-5">
        <div class="row justify-content-center">

            <transition leave-active-class="animated fadeOut fast" v-on:after-leave="after_user_types_leave">
                <div class="col-lg-5 col-md-6" v-if="show_user_types">
                    <div class="reg-option" @click="usertype_checked(0)">
                        Masażysta <i class="fas fa-spa ml-4"></i>
                    </div>
                </div>
            </transition>
            <transition leave-active-class="animated fadeOut fast">
                <div class="col-lg-5 col-md-6 mt-sm-5 mt-xs-5 mt-md-0" v-if="show_user_types">
                    <div class="reg-option" @click="usertype_checked(1)">
                        Klient <i class="fas fa-user ml-4"></i>
                    </div>
                </div>
            </transition>

            <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast" v-on:after-leave="after_registration_leave">
                <div class="col-sm-12 text-center mt-4" v-if="show_registration">
                    <div v-if="user_type==0">
                        <h1 class="pb-4">Rejestracja masażysty</h1>
                        <hr>
                        <form @submit.prevent="submit" method="post">
                            <input type="hidden" name="_token" v-bind:value="csrf">
                            <div class="form-group mt-4 align-items-center" style="font-size: 1.1em">
                                <div class="row" style="margin-top: 3rem;">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="name" class="col-form-label">Imię</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input required type="text" id="name" v-validate="'required'" v-model="user_fields.name" name="name" :class="{'wrong': errors.has('name')}" class="form-control">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('name') }}</span>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="surname" class="col-form-label">Nazwisko</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input v-validate required type="text" name="surname" :class="{'wrong': errors.has('surname')}" class="form-control" id="surname" v-model="user_fields.surname">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('surname') }}</span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="email" class="col-form-label">Email</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input v-validate="'email'" required type="text" id="email" name="email" v-model="user_fields.email" :class="{'wrong': errors.has('email')}" class="form-control">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('email') }}</span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="password" class="col-form-label">Hasło</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input v-validate="'min:8'" required type="password" id="password" v-model="user_fields.password" name="password" :class="{'wrong': errors.has('password')}" class="form-control">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('password') }}</span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="password-repeat" class="col-form-label">Powtórz hasło</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input v-validate="{is: user_fields.password}" required type="password" id="password2" v-model="user_fields.password2" name="password2" :class="{'wrong': errors.has('password2')}" class="form-control">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('password2') }}</span>
                                    </div>
                                </div>
                                <div class="form-check mt-4">
                                    <input v-validate required v-model="user_fields.accept_terms" type="checkbox" class="form-check-input" name="accept_terms" id="accept_terms">
                                    <label class="form-check-label" for="accept_terms">Akceptuję <a href="#">regulamin</a></label>
                                </div>
                                <span class="error">{{ errors.first('accept_terms') }}</span>
                                <div class="align-items-center" style="margin-top: 3rem;">
                                    <button class="btn-first btn mx-auto" style="width: 30%;font-size: 1.4em">
                                        Zarejestruj się!
                                    </button>
                                </div>

                            </div>
                            
                        </form>
                    </div>


                    <div v-if="user_type==1">
                        <h1>Rejestracja klienta</h1>
                        <hr>
                        <form @submit.prevent="submit" method="post">
                            <input type="hidden" name="_token" v-bind:value="csrf">
                            <div class="form-group mt-4 align-items-center" style="font-size: 1.1em">
                                <div class="row" style="margin-top: 3rem;">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="name" class="col-form-label">Imię</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input required type="text" id="name" v-validate="'required'" v-model="user_fields.name" name="name" :class="{'wrong': errors.has('name')}" class="form-control">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('name') }}</span>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="surname" class="col-form-label">Nazwisko</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input v-validate required type="text" name="surname" :class="{'wrong': errors.has('surname')}" class="form-control" id="surname" v-model="user_fields.surname">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('surname') }}</span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="email" class="col-form-label">Email</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input v-validate="'email'" required type="text" id="email" name="email" v-model="user_fields.email" :class="{'wrong': errors.has('email')}" class="form-control">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('email') }}</span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="password" class="col-form-label">Hasło</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input v-validate="'min:8'" required type="password" id="password" v-model="user_fields.password" name="password" :class="{'wrong': errors.has('password')}" class="form-control">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('password') }}</span>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-2 offset-lg-3 offset-md-1">
                                        <label for="password-repeat" class="col-form-label">Powtórz hasło</label>
                                    </div>
                                    <div class="col-lg-4 col-md-8">
                                        <input v-validate="{is: user_fields.password}" required type="password" id="password2" v-model="user_fields.password2" name="password2" :class="{'wrong': errors.has('password2')}" class="form-control">
                                    </div>
                                    <div clas="col-sm-3">
                                        <span class="error">{{ errors.first('password2') }}</span>
                                    </div>
                                </div>
                                <div class="form-check mt-4">
                                    <input v-validate required v-model="user_fields.accept_terms" type="checkbox" class="form-check-input" name="accept_terms" id="accept_terms">
                                    <label class="form-check-label" for="accept_terms">Akceptuję <a href="#">regulamin</a></label>
                                </div>
                                <span class="error">{{ errors.first('accept_terms') }}</span>
                                <div class="align-items-center mx-auto" style="margin-top: 3rem;">
                                    <button class="btn-first btn mx-auto" style="width: 30%;font-size: 1.4em">
                                        Zarejestruj się!
                                    </button>
                                </div>

                            </div>
                            
                        </form>
                    </div>
                </div>
            </transition>


            <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
                <div v-if="registered" class="justify-content-center text-center">
                    <h1>Rejestracja przebiegła pomyślnie!</h1>
                    <h5 class="mt-4 pl-5 pr-5">Na twój email <b>({{ user_fields.email }})</b> wysłaliśmy link z potwierdzeniem rejestracji.</h5>
                    <h5 class="mt-2 pl-5 pr-5">Po potwierdzeniu będziesz mógł w pełni korzystać z naszego serwisu!</h5>
                    <transition leave-active-class="animated fadeOut fast">
                        <div v-if="send_again==false">
                            <form method="post" @submit.prevent="resend"> <!-- action="email/resend" -->
                                <input type="hidden" name="_token" v-bind:value="csrf">
                                <h6 class="mt-4">Nie otrzymałeś maila? <span class="send-again" @click="resend"> Wyślemy go jeszcze raz.</span></h6>
                            </form>
                        </div>
                    </transition>
                    <!-- <h6>Jeśli nie otrzymałeś maila<button class="btn btn-primary" @click="resend">wyślemy go jeszcze raz</button></h6> -->

                </div>
            </transition>
        </div>
    </div>
</template>

<style scoped>

.send-again{
    color:#7cd4fa;
}
.send-again:hover{
    text-decoration: underline;
    cursor: pointer;
}


</style>

<script>
    export default {
        data() {
            return {
                show_user_types: true,
                show_registration: false,
                user_type: 0,
                serverside_errors: '',
                user_fields: {},
                registered:false,
                send_again:false,

            }
        },
        props:['csrf'],
        methods: {
            usertype_checked: function(option){
                this.user_type = option;
                this.show_user_types = false;
            },
            after_user_types_leave: function(el){
                this.show_registration = true;
            },
            submit(el) {
              this.$validator.validateAll().then((result) => {
                if (result) {
                    this.user_fields.role = this.user_type;
                    axios.post('/register', this.user_fields).then(response => {
                        this.show_registration=false;

                    }).catch(error => {
                        console.log(error);
                        // if (error.response.status === 422) {
                        //   this.serverside_errors = error.response.data.errors || {};
                        // }
                    });
                } else{
                    el.preventDefault();
                }
              });
            },
            after_registration_leave(el){
                this.registered=true;
            },
            resend(el){
                axios.post('/email/resend',this.user_fields).then(response => {
                    this.send_again = true;
                }).catch(error => {
                    console.log(error);
                })
            }
        }
    }
</script>


