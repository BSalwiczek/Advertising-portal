<template>
  <div>

  <div class="box-container mt-5 text-center" style="background-color:#fafcfe;">
    <div class="text-center">
      <h3 class="mb-3 mt-3">Podziel się swoją opinią na temat tego masażysty</h3>
      <stars :initial-note="yourOpinion ? yourOpinion.note : '0'" @note-updated="updateNote"></stars>
      <div class="mx-auto w-75 mt-3">
        <h5>Napisz co sprawiło że skorzystałeś z jej/jego usług. Jakie są Twoje wrażenia, czy masaż spełnij Twoje oczekiwania? Czy poleciłbyś ją/go znajomym? Twoja opinia może wpłynąć na decyzję wielu osób!</h5>
        <textarea v-validate="'max:3000'" name="opinion" v-model="opinion_text" v-if="login" class="form-control"></textarea>
        <textarea  v-else disabled class="form-control"></textarea>
        <div class="error mt-3">{{ errors.first('opinion') }}</div>
        <div v-if="!login" class="must-login">
          Aby podzielić się opinią należy się <a href="/login">zalogować</a>
        </div>
        <button class="btn btn-first mx-auto mt-4" @click="submitOpinion" v-if="login" style="width: 30%;font-size: 1.4em;padding-top:2%;padding-bottom:2%">
            Wyślij opinię
        </button>
      </div>

    </div>
  </div>
  <opinions ref="opinions" :post-id="postId"></opinions>
</div>
</template>

<style>
textarea.form-control{
  resize: vertical;
  background-color: #fafcfe;
  margin-top: 1.5rem;
  border-color: #ddd;
  min-height: 15vh;
}
textarea.form-control:active,
textarea.form-control:focus{
  box-shadow: none;
  border-color: #ddd;
}
.must-login{
  position: relative;
  left: 50%;
  font-size: 1.8em;
  transform:translate(-50%,-50%);
  top: -9.5vh;
}
@media screen and (max-width: 1100px) {
  textarea.form-control{
    min-height: 50vh;
  }
  .must-login{
    font-size: 1.6em;
    top: -27vh;
  }
}
@media screen and (max-width: 500px) {
  textarea.form-control{
    min-height: 60vh;
  }
  .must-login{
    font-size: 1.5em;
    top: -32vh;
  }
}
</style>

<script>
import Stars from './Stars.vue'
import Opinions from './Opinions.vue'
export default{
  data(){
    return{
      opinion_text: '',
      note: 0,
    }
  },
  props:{
    'login':Boolean,
    'postId':Number,
    'yourOpinion':Object
  },
  components:{
    'stars':Stars,
    'opinions':Opinions,
  },
  mounted(){
    if(this.yourOpinion !== undefined && Object.keys(this.yourOpinion).length>0)
    {
      this.opinion_text = this.yourOpinion.opinion;
      this.note = this.yourOpinion.note;
    }
  },
  methods:{
    submitOpinion(){
      this.$validator.validateAll().then((result) => {
        if (result) {
          axios.post('/new-opinion',{
            'opinion':this.opinion_text,
            'note':this.note,
            'post_id':this.postId
          }).then((response)=>{
            this.$refs.opinions.addOpinion(response.data);
          })
        }
      });
    },
    updateNote(note){
      this.note = note;
    }
  }
}
</script>
