<template>
  <div>
    <form action="/masazysta/profil" ref="goToMessages" method="post" style="display:none">
      <input type="hidden" name="_token" id="csrf-token" :value="csrf" />
      <input :value="userId" name="friendId" />
      <input value="1" name="option" />
    </form>
<button @click="contactHim()" class="btn btn-contact mx-auto mt-3">Kontakt</button>
  </div>
</template>

<style scoped>
.btn-contact{
  background-color: #53C5F7;
}
.btn-contact {
  display: block;
  font-family: "Montserrat", "Trebuchet MS", Helvetica, sans-serif;
  -webkit-font-smoothing: antialiased;
  position: relative;
  padding: 1em 1.4em;
  padding-right: 4.7em;
  background: #53C5F7;
  border: none;
  color: white;
  line-height: 30px;
  transition: .2s;
}
.btn-contact:before,
.btn-contact:after {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  width: 2.8em;
  content: "\00a0";
  padding-top: inherit;
  font-family: 'FontAwesome', sans-serif;
  font-size: 1.2em;
  text-align: center;
  transition: .2s;
}
.btn-contact:before {
  background: rgba(0, 0, 0, 0.09999999999999998);
}
.btn-contact:hover {
  background: #53C5F7;
  color: white;
}
.btn-contact:active,
.btn-contact:focus {
  background: #53C5F7;
  outline: none;
}
.btn-contact:after {
  content: "\F0E0";
}

.btn-contact:hover:after,.btn-contact:hover:before {
  font-size: 1.4em;
  /*transition: all .2s*/;
}
.btn-contact:hover{
  background-color: #42b883
}

</style>

<script>
export default{
  data(){
    return{

    }
  },
  props:{
    'userId': Number,
    'csrf':String
  },
  methods:{
    contactHim(){
      this.$refs.goToMessages.submit();
    }
  }
}
</script>
