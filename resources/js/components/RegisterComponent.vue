<style scoped>
@import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
</style>
<template>
    <div class="container reg-container mt-5">
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

            <transition enter-active-class="animated fadeIn">
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
                                    <button @click="submit" class="button_slide slide_right ml-5" style="width: 30%;font-size: 1.4em">
                                        Zarejestruj się!
                                    </button>
                                </div>

                            </div>
                            
                        </form>
                    </div>


                    <div v-if="user_type==1">
                        <h1>Rejestracja klienta</h1>
                        <form>
                            <label for="login" class="col-form-label"></label>
                            <input type="text" name="login">
                        </form>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<style scoped>
/*=================register=================*/

.fadeOutLeft,.fadeOutRight{
    transition-duration: 5s !important;
}

.reg-container{
    padding-top: 3rem;
    padding-bottom: 3rem;
    background-color: white;
    -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.05);
    -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.05);
    box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.05);
}

.reg-option{
    background-color: #42b883;
    min-height: 200px;
    border-radius: 20px;
    text-align: center;
    display : flex;
    align-items : center;
    justify-content: center;
    font-size: 1.5em;
    color: #FFF;
    cursor: pointer;
    transition: font-size ease-in-out .3s;

}

.reg-option:hover{
    font-size: 1.7em;
    transition: font-size ease-in-out .3s;

}

.form-control{
    border-radius: 2px;
    border-width: 1px;
    border-color: #ddd;
}

.form-control:focus{
    -webkit-box-shadow: 0px 0px 8px 4px rgba(124,212,250,0.3);
    -moz-box-shadow: 0px 0px 8px 4px rgba(124,212,250,0.3);
    box-shadow: 0px 0px 8px 4px rgba(124,212,250,0.3);
    border-color: #7cd4fa;
}

.wrong{
    border-color: red;
}

.error{
    font-size: 0.8em;
    color: red;
}


/*========checkbox======*/
/* The container */


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
                    console.log(this.user_fields);
                    axios.post('/user/create', this.user_fields).then(response => {
                        alert('Registered user!');


                    }).catch(error => {
                        if (error.response.status === 422) {
                          this.serverside_errors = error.response.data.errors || {};
                        }
                    });
                } else{
                    el.preventDefault();
                }
              });
            }
        }
    }
</script>


