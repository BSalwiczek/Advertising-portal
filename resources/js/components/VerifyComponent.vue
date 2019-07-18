<template>
    <div class="container auth-container mt-5">
        <div class="row justify-content-center">
            <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
                    <div class="justify-content-center text-center">
                        <h1>Potwierdź adres email!</h1>
                        <h5 class="mt-4 pl-5 pr-5">Na twój email <b>({{ email }})</b> wysłaliśmy link z potwierdzeniem rejestracji.</h5>
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
        data(){
            return {
                send_again:false,
                user_fields: {},
            }
        },
        props:['csrf','email'],
        methods: {
            resend(el){
                this.user_fields.email = this.email;
                axios.post('/email/resend',this.user_fields).then(response => {
                    this.send_again = true;
                }).catch(error => {
                    console.log(error);
                })
            }
        }
    }
</script>