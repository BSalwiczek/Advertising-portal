<template>
<div class="text-center p-3 pt-5">
    <h1>Ustawienia użytkownika</h1>
    <form method="post" enctype="multipart/form-data" v-on:submit.prevent="submit">
        <input type="hidden" name="_token" v-bind:value="csrf">
        <label style="max-width:25%" for="name" class="inp mt-5 d-block">
            <input required v-validate="'required|max:30|alpha'" type="text" id="name" v-model="user.name" class="better-input" placeholder=" " name="name" :class="{'wrong': errors.has('name')}">
            <span class="label">Imie</span>
            <span class="border-b"></span>
        </label>
        <span class="error">{{ errors.first('name') }}</span>

        <label style="max-width:25%;margin-top: 2.5rem" for="surname" class="inp d-block">
            <input required v-validate="'required|max:30|alpha'" type="text" id="surname" v-model="user.surname" class="better-input" name="surname" placeholder=" " :class="{'wrong': errors.has('surname')}">
            <span class="label">Nazwisko</span>
            <span class="border-b"></span>
        </label>
        <span class="error">{{ errors.first('surname') }}</span>

        <div class="text-center">
            <button class="btn btn-first p-3 mt-5">Zapisz zmiany</button>
        </div>

        <transition leave-active-class="animated fadeOut fast">
            <loader v-if="loading"></loader>
        </transition>

    </form>
    <alert-success v-on:alert-closed="changed=false" message="Ustawienia użytkownika zostały zmienione" v-if="changed"></alert-success>
</div>
</template>

<script type="text/javascript">
import alertsuccess from '../../alerts/AlertSuccessComponent.vue';
import loadingComponent from '../../others/LoadingComponent.vue';
export default {
    data() {
        return {
            user: {},
            changed: false,
            loading: false,
        }
    },
    props: {
        userData: Object,
        csrf: String,
    },
    mounted() {
        this.setUserData();

    },
    components: {
        'alert-success': alertsuccess,
        'loader': loadingComponent,
    },
    methods: {
        setUserData() {
        	axios.get('/getAuthUser').then((result)=>{
						this.user = result.data;
					});
        },
        submit() {
            if (this.user.name != this.userData.name || this.user.surname != this.userData.surname) {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        var component = this;
                        this.loading = true;
                        axios.post('/zapisz-ustawienia-uzytkownika-masazysty', this.user).then(function(response) {
                            component.loading = false;
                            if (response.status == 200) {
                                component.changed = true;
                            }
                        })
                    }
                });
            }
        }
    }
}
</script>
