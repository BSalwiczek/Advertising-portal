<template>
  <div class="mt-5">
    <h3 class="mx-2"><i style="margin-right: 1%; color: rgb(9, 162, 229);" class="fas fa-user-graduate"></i> Wykształcenie</h3>
    <hr class="w-25" />

    <div class="row">
      <div class="col-lg-8 col-xl-6 mx-auto" style="justify-content:center">
        <div class="post py-4 my-2" style="position:relative" v-for="education in eduCoExp.education" :key="education.id">
          <div class="row">
            <div class="col-lg-3 col-5 pr-lg-1">
              <label style="font-size:0.8em">Rozpoczęcie</label>
              <input v-validate="'required|max:16'" type="text" :id="addStrings('since',education.id)" :name="addStrings('since',education.id)"
              v-model="education.since" class="form-control d-inline-block"/>
              <span class="error">{{ errors.first(addStrings('since',education.id)) }}</span>
            </div>
            <div class="col-lg-1 col-2 px-1" style="line-height:85px;font-size:1.3em">
              <span>–</span>
            </div>
            <div class="col-lg-3 col-5 px-lg-1">
              <label :class="{'not-active': education.to.length==0}" style="font-size:0.8em">Zakończenie</label>
              <input :class="{'not-active': education.to.length==0}" v-validate="'max:16'" type="text" :id="addStrings('to',education.id)" :name="addStrings('to',education.id)" c
              v-model="education.to" class="form-control"/>
              <span class="error">{{ errors.first(addStrings('to',education.id)) }}</span>
            </div>
            <div class="col-lg-5 col-12 pl-lg-1 mt-2 mt-lg-0">
              <label style="font-size:0.8em">Krótki opis</label>
              <input v-validate="'required|max:255'" type="text" :id="addStrings('shortDescription',education.id)" :name="addStrings('shortDescription',education.id)"
              v-model="education.description" class="form-control"/>
              <span class="error">{{ errors.first(addStrings('shortDescription',education.id)) }}</span>

            </div>
          </div>
          <span @click="deleteEducation(education.id)"><i class="fas fa-times delete shake"></i></span>
        </div>
      </div>
    </div>

    <button @click="addEducation()" class="add-exp plus-button mx-auto mb-4"></button>


    <h3 class="mx-2"><i style="margin-right: 1%; color: rgb(9, 162, 229);" class="fas fa-chalkboard-teacher"></i> Kursy i szkolenia</h3>
    <hr class="w-25" />

    <div class="row">
      <div class="col-lg-8 col-xl-6 mx-auto" style="justify-content:center">
        <div class="post py-4 my-2" style="position:relative" v-for="course in eduCoExp.courses" :key="course.id">
          <div class="row">
            <div class="col-lg-3 col-5 pr-lg-1">
              <label style="font-size:0.8em">Rozpoczęcie</label>
              <input v-validate="'required|max:16'" type="text" :id="addStrings('sincex',course.id)" :name="addStrings('sincex',course.id)"
              v-model="course.since" class="form-control d-inline-block"/>
              <span class="error">{{ errors.first(addStrings('sincex',course.id)) }}</span>
            </div>
            <div class="col-lg-1 col-2 px-1" style="line-height:85px;font-size:1.3em">
              <span>–</span>
            </div>
            <div class="col-lg-3 col-5 px-lg-1">
              <label :class="{'not-active': course.to.length==0}" style="font-size:0.8em">Zakończenie</label>
              <input :class="{'not-active': course.to.length==0}" v-validate="'max:16'" type="text" :id="addStrings('tox',course.id)" :name="addStrings('tox',course.id)"
              v-model="course.to" class="form-control"/>
              <span class="error">{{ errors.first(addStrings('tox',course.id)) }}</span>
            </div>
            <div class="col-lg-5 col-12 pl-lg-1 mt-2 mt-lg-0">
              <label style="font-size:0.8em">Krótki opis</label>
              <input v-validate="'required|max:255'" type="text" :id="addStrings('shortDescriptionx',course.id)" :name="addStrings('shortDescriptionx',course.id)"
              v-model="course.description" class="form-control"/>
              <span class="error">{{ errors.first(addStrings('shortDescriptionx',course.id)) }}</span>
            </div>
          </div>
          <span @click="deleteCourse(course.id)"><i class="fas fa-times delete shake"></i></span>
        </div>
      </div>
    </div>

    <button @click="addCourse()" class="add-exp plus-button mx-auto mb-4"></button>


    <h3 class="mx-2"><i style="margin-right: 1%; color: rgb(9, 162, 229);" class="fas fa-medal"></i> Doświadczenie</h3>
    <hr class="w-25" />

    <div class="row">
      <div class="col-lg-8 col-xl-6 mx-auto" style="justify-content:center">
        <div class="post py-4 my-2" style="position:relative" v-for="experience in eduCoExp.experience" :key="experience.id">
          <div class="row">
            <div class="col-lg-3 col-5 pr-lg-1">
              <label style="font-size:0.8em">Rozpoczęcie</label>
              <input v-validate="'required|max:16'" type="text" :id="addStrings('sincey',experience.id)" :name="addStrings('sincey',experience.id)"
              v-model="experience.since" class="form-control d-inline-block"/>
              <span class="error">{{ errors.first(addStrings('sincey',experience.id)) }}</span>
            </div>
            <div class="col-lg-1 col-2 px-1" style="line-height:85px;font-size:1.3em">
              <span>–</span>
            </div>
            <div class="col-lg-3 col-5 px-lg-1">
              <label :class="{'not-active': experience.to.length==0}" style="font-size:0.8em">Zakończenie</label>
              <input :class="{'not-active': experience.to.length==0}" v-validate="'max:16'" type="text" :id="addStrings('toy',experience.id)" :name="addStrings('toy',experience.id)"
              v-model="experience.to" class="form-control"/>
              <span class="error">{{ errors.first(addStrings('toy',experience.id)) }}</span>
            </div>
            <div class="col-lg-5 col-12 pl-lg-1 mt-2 mt-lg-0">
              <label style="font-size:0.8em">Krótki opis</label>
              <input v-validate="'required|max:255'" type="text" :id="addStrings('shortDescriptiony',experience.id)" :name="addStrings('shortDescriptiony',experience.id)"
              v-model="experience.description" class="form-control"/>
              <span class="error">{{ errors.first(addStrings('shortDescriptiony',experience.id)) }}</span>
            </div>
          </div>
          <span @click="deleteExperience(experience.id)"><i class="fas fa-times delete shake"></i></span>
        </div>
      </div>
    </div>

    <button @click="addExperience()" class="add-exp plus-button mx-auto mb-4"></button>


  </div>
</template>

<style scoped>
.delete{
  position: absolute;
  right: 0.7rem;
  top: 0.8rem;
	color: #333;
}
.delete:hover{
	color: red;
	cursor: pointer;
	animation: shake 0.2s;
}

.not-active{
  opacity: 0.6
}

@keyframes shake {
  0% { transform: translate(1px, 1px) rotate(0deg); }
  20% { transform: translate(-3px, 0px) rotate(1deg); }
  40% { transform: translate(1px, -1px) rotate(1deg); }
  60% { transform: translate(-3px, 1px) rotate(0deg); }
  80% { transform: translate(-1px, -1px) rotate(1deg); }
  100% { transform: translate(1px, -2px) rotate(-1deg); }
}

.add-exp:hover{
  background-color: #42b883;
  border-color: #42b883;
  transition: all 0.2s ease-in-out;
}

.add-exp:hover::after,.add-exp:hover::before{
  background-color: #fff;
  transition: all 0.2s ease-in-out;
}

/* .add-notice:hover{
  text-decoration: underline;
  cursor: pointer;
} */
</style>

<script>
export default{
  data(){
    return {

    }
  },
  props:{
    eduCoExp: Object,
  },
  mounted(){
  },
  methods:{
    addEducation(){
      this.eduCoExp.education.push({});
      this.$set(this.eduCoExp.education[this.eduCoExp.education.length-1],'id',
      this.eduCoExp.education.length-1 == 0 ?
      this.eduCoExp.education.length-1 :
      this.eduCoExp.education[this.eduCoExp.education.length-2].id+1);
      this.$set(this.eduCoExp.education[this.eduCoExp.education.length-1],'since','');
      this.$set(this.eduCoExp.education[this.eduCoExp.education.length-1],'to','');
      this.$set(this.eduCoExp.education[this.eduCoExp.education.length-1],'description','');
    },
    deleteEducation(id){
      for(var i=0;i<this.eduCoExp.education.length;i++)
      {
        if(this.eduCoExp.education[i].id == id)
        {
          this.eduCoExp.education.splice(i,1);
          return;
        }
      }
    },

    addCourse(){
      this.eduCoExp.courses.push({});
      this.$set(this.eduCoExp.courses[this.eduCoExp.courses.length-1],'id',this.eduCoExp.courses.length-1);
      this.$set(this.eduCoExp.courses[this.eduCoExp.courses.length-1],'since','');
      this.$set(this.eduCoExp.courses[this.eduCoExp.courses.length-1],'to','');
      this.$set(this.eduCoExp.courses[this.eduCoExp.courses.length-1],'description','');
    },
    deleteCourse(id){
      for(var i=0;i<this.eduCoExp.courses.length;i++)
      {
        if(this.eduCoExp.courses[i].id == id)
        {
          this.eduCoExp.courses.splice(i,1);
          return;
        }
      }
    },

    addExperience(){
      this.eduCoExp.experience.push({});
      this.$set(this.eduCoExp.experience[this.eduCoExp.experience.length-1],'id',this.eduCoExp.experience.length-1);
      this.$set(this.eduCoExp.experience[this.eduCoExp.experience.length-1],'since','');
      this.$set(this.eduCoExp.experience[this.eduCoExp.experience.length-1],'to','');
      this.$set(this.eduCoExp.experience[this.eduCoExp.experience.length-1],'description','');
    },
    deleteExperience(id){
      for(var i=0;i<this.eduCoExp.experience.length;i++)
      {
        if(this.eduCoExp.experience[i].id == id)
        {
          this.eduCoExp.experience.splice(i,1);
          return;
        }
      }
    },

    addStrings(x,y)
    {
      return String(x)+String(y);
    },

    validate()
    {
      this.$validator.validateAll().then((result) => {
        if(result){
          this.$emit('all-validated');
        }
        })
    }

  }
}
</script>
