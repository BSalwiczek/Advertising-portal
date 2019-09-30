<template>
<div class="text-center p-3 pt-5">
    <h1>Ustawienia użytkownika</h1>
    <hr class="w-50 mt-4"/>
    <form method="post" v-on:submit.prevent="">
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

        <experience-and-rest @all-validated="postData()" ref="educoexp" :eduCoExp = "eduCoExp"></experience-and-rest>

        <div class="text-center">
            <button @click="submit" class="btn btn-first p-3 my-3">Zapisz zmiany</button>
        </div>

        <transition leave-active-class="animated fadeOut fast">
            <loader v-if="loading"></loader>
        </transition>

    </form>


    <alert-success :showNow="false" ref="alertS" message="<b>Gratulacje!</b> Zmiany zostały zapisane."></alert-success>
</div>
</template>

<script type="text/javascript">
import alertsuccess from '../../alerts/AlertSuccessComponent.vue';
import loadingComponent from '../../others/LoadingComponent.vue';
import experienceAndRest from './ExperienceAndRest.vue';
export default {
    data() {
        return {
            user: {},
            changed: false,
            loading: true,
            eduCoExp: {
              education:[],
              courses:[],
              experience:[]
            }
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
        'experience-and-rest':experienceAndRest
    },
    methods: {
        setUserData() {
        	axios.get('/get-user-and-educoexp').then((result)=>{
            console.log(result);
            this.user.name = result.data.name;
            this.user.surname = result.data.surname;
						this.user.id = result.data.id;
            var educoexps = result.data.educoexps;
            for(var i=0;i<educoexps.length;i++)
            {
              if(educoexps[i].category == "education")
              {
                this.eduCoExp.education.push({});
                this.$set(this.eduCoExp.education[this.eduCoExp.education.length-1],'id',educoexps[i].id);
                this.$set(this.eduCoExp.education[this.eduCoExp.education.length-1],'since',educoexps[i].since);
                this.$set(this.eduCoExp.education[this.eduCoExp.education.length-1],'to',educoexps[i].to === null ? '' : educoexps[i].to);
                this.$set(this.eduCoExp.education[this.eduCoExp.education.length-1],'description',educoexps[i].description);
              }
              if(educoexps[i].category == "courses")
              {
                this.eduCoExp.courses.push({});
                this.$set(this.eduCoExp.courses[this.eduCoExp.courses.length-1],'id',educoexps[i].id);
                this.$set(this.eduCoExp.courses[this.eduCoExp.courses.length-1],'since',educoexps[i].since);
                this.$set(this.eduCoExp.courses[this.eduCoExp.courses.length-1],'to',educoexps[i].to === null ? '' : educoexps[i].to);
                this.$set(this.eduCoExp.courses[this.eduCoExp.courses.length-1],'description',educoexps[i].description);
              }
              if(educoexps[i].category == "experience")
              {
                this.eduCoExp.experience.push({});
                this.$set(this.eduCoExp.experience[this.eduCoExp.experience.length-1],'id',educoexps[i].id);
                this.$set(this.eduCoExp.experience[this.eduCoExp.experience.length-1],'since',educoexps[i].since);
                this.$set(this.eduCoExp.experience[this.eduCoExp.experience.length-1],'to',educoexps[i].to === null ? '' : educoexps[i].to);
                this.$set(this.eduCoExp.experience[this.eduCoExp.experience.length-1],'description',educoexps[i].description);
              }
            }
            this.loading = false;
					});
        },
        submit() {
          this.$validator.validateAll().then((result) => {
            if(result){
              this.$refs.educoexp.validate();
            }
          });
        },

        postData(){
          this.loading = true;
          axios.post('/zapisz-ustawienia-uzytkownika-masazysty', {...this.user,...this.eduCoExp}).then((response) => {
              this.loading = false;
              if (response.status == 200) {
                  this.$refs.alertS.show = true;
              }
          })
        }
    }
}
</script>
