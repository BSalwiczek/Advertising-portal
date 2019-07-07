<style scoped>
@import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
</style>
<template>
    <div class="container reg-container mt-5">
        <div class="row justify-content-center">

            <transition leave-active-class="animated fadeOut fast" v-on:after-leave="after_user_types_leave">
                <div class="col-lg-5 col-md-6" v-if="show_user_types">
                    <div class="reg-option" @click="usertype_checked(0)">
                        Masażysta lub fizjoterapeuta <i class="fas fa-spa ml-4"></i>
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
                <div class="col-sm-12 text-center" v-if="show_registration">
                    <div v-if="user_type==0">
                        <h1>Rejestracja masażysty lub fizjoterapeuty</h1>
                        <form>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                   <label for="name" class="col-form-label">Imię</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                    <div class="col-sm-6">
                                    <label for="surname" class="col-form-label">Nazwisko</label>
                                    <input type="text" name="surname" class="form-control">
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
</style>

<script>
    export default {
        data() {
            return {
                show_user_types: true,
                show_registration: false,
                user_type: 0,
            }
        },
        methods: {
            usertype_checked: function(option){
                this.user_type = option;
                this.show_user_types = false;
            },
            after_user_types_leave: function(el){
                this.show_registration = true;
            }
        }
    }
</script>


