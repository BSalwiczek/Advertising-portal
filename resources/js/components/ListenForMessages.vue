<template>
  <div>
    <a class="my-auto msg-icon" ref="dropdownbutton" @click="openWindow()">
      <i class="fas fa-envelope"><span v-if="messages.length>0" class="num-in-circle-1">{{ messages.length }}</span></i>
      <span class="d-lg-none">Wiadomości</span>
    </a>
    <div v-if="showWindow" class="window"  v-closable="{
            exclude: ['dropdownbutton'],
            handler: 'openWindow'
          }">
          <h5 class="text-center dynamic-font unseen-text my-lg-2 my-0 py-2 py-lg-0 mb-lg-3">Nieprzeczytane wiadomości &nbsp;<span v-if="messages.length>0" class="num-in-circle">{{ messages.length }}</span></h5>
      <h5 v-if="messages.length==0" class="text-center dynamic-font unseen-text my-lg-2 my-0 pb-2 pb-lg-0 mb-lg-3">Brak</h5>
      <div v-for="(message,index) in messages" :key="index" class="message mt-lg-2" @click="viewMessage(message.author_id)">
        <div class="row dynamic-font">
          <div class="col-lg-2 col-4 p-0 pl-3">
            <img :src="getProfileImgUrl(message.profile_img)"  class="rounded-circle avatar" style="max-width: 200px; width: 100%"/>
          </div>
          <div class="col-lg-10 col-8">
            <div class="dynamic-font-big">
              <strong>{{ message.name }} {{ message.surname }}</strong>
              <div class="text-right d-inline-block dynamic-font-small ml-1" v-text="getTimeDiffFromNow(message.msg_created)"></div>
            </div>
            <b><span v-text="shortenIfTooLong(message.message,50)"></span></b>
          </div>
        </div>
      </div>
    </div>
    <form action="/masazysta/profil" ref="goToMessages" method="post" style="display:none">
      <input type="hidden" name="_token" id="csrf-token" :value="csrf" />
      <input :value="chosenFriendId" name="friendId" />
      <input value="1" name="option" />
    </form>
    <audio ref="audio" src="/storage/sounds/message.wav" type="audio/wav"></audio>
  </div>
</template>

<style scoped>
@media screen and (max-width: 992px) {
  .message{
    color: #5d5d5d;
  }
  .message:not(:last-child){
    border-bottom: 1px solid #eee;
  }
  .unseen-text{
    color: #5d5d5d;
    background-color: #f1f1f1;
  }
  a.msg-icon{
    background-color: #fff;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
  }
  a.msg-icon:hover{
    color: #5d5d5d !important;
    cursor: pointer;
    background-color: #eee !important;
    transition: all .2s
  }
}
@media screen and (min-width: 992px) {
  .window{
    position: absolute;
    width: 20%;
    min-width: 250px;
    max-height: 500px;
    overflow-y: auto;
    overflow-x: hidden;
    right: 200px;
    top: 65px;
    z-index: 30;
    padding: 0.5rem;
    padding-top: 0.8rem;
    background-color: #f9f9f9;
    -webkit-box-shadow: 0px 5px 12px -4px rgba(0,0,0,0.2);
  -moz-box-shadow: 0px 5px 12px -4px rgba(0,0,0,0.2);
  box-shadow: 0px 5px 12px -4px rgba(0,0,0,0.2);
  /* font-family: 'Bree Serif', serif; */
  }

  .dynamic-font{
  	font-size: 0.8vw;
  }
}

/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #AAA;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #888;
}


a.msg-icon{
  line-height: 50px;
  color: #6F1D1B;
  transition: all .2s
}
a.msg-icon:hover{
  color: #B35A58;
  cursor: pointer;
  transition: all .2s
}

.num-in-circle,.num-in-circle-1{
  background-color: #F9DC5C;
  padding: 0.2rem 0.6rem;
  display: inline-block;
  border-radius: 1000px;

}

.num-in-circle-1{
  position:relative;
  padding: 0.2rem 0.4rem;
  font-size: 0.8rem;
  left: -6px;
  top: -10px;
  color: #013A52 !important;
}

.message{
  width: 100%;
  background-color: #fff;
  font-size: 80%;
  font-weight: normal;
  padding: 0.5rem;
    transition: all .2s
}

.message:hover{
  background-color: #eee;
  cursor: pointer;
  transition: all .2s
}

@media screen and (max-width: 992px) {
  .dynamic-font{
	font-size: 1.2vw;
}
}
@media screen and (max-width: 500px) {
  .dynamic-font{
	font-size: 1.9vw;
}
}

.dynamic-font-big{
	font-size: 1vw;
}
@media screen and (max-width: 992px) {
  .dynamic-font-big{
	font-size: 1.4vw;
}
}
@media screen and (max-width: 500px) {
  .dynamic-font-big{
	font-size: 2.1vw;
}
}

.dynamic-font-small{
	font-size: 0.6vw;
}
@media screen and (max-width: 992px) {
  .dynamic-font-big{
	font-size: 0.8vw;
}
}
@media screen and (max-width: 500px) {
  .dynamic-font-big{
	font-size: 1.7vw;
}
}
</style>

<script>
import EventBus from './EventBus.vue';
export default{
  data(){
    return{
      showWindow: false,
      messages:[
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"},
        // {"message":"wedwed","author_id":"2","name":"Jan","surname":"Kowalskii","profile_img":"default.png","msg_created":"2019-09-06 08:56:21"}

      ],
      chosenFriendId: 0,
      friends:[],
    }
  },
  mounted(){
    this.getUnseenMessages();
    EventBus.$on('seen-message',(id)=>{
      let messageIndexToRemove = -1;
      this.messages.forEach((el,index)=>{
        if(el.author_id==id)
          messageIndexToRemove = index;
      })
      this.messages.splice(messageIndexToRemove,1);
      this.$emit('update-number',this.messages.length);
    });
    this.listenForMessagesFromFriends();
  },
  props:{
    csrf: String,
    userData: Object,
  },
  methods:{
    getUnseenMessages(){
      axios.post('/get-unseen-messages').then((response)=>{
        response.data.forEach((el)=>{
            this.messages.push({
              message: el.message,
              author_id: el.sender_id,
              name: el.name,
              surname: el.surname,
              profile_img: el.profile_img,
              msg_created: el.msg_created,
            })

        });
        this.$emit('update-number',this.messages.length);
      })
    },
    listenForMessagesFromFriends(){
      axios.get('/getFriends').then((response)=>{
        response.data.forEach((el)=>{
					let idd = 0;
					if(el.sender_id == this.userData.id){
						idd = parseInt(el.receiver_id);
					}else{
						idd = parseInt(el.sender_id)
					};
					this.friends.push({
						 surname:el.surname,
						 name:el.name,
						 profile_img:el.profile_img,
						 id:idd,
					});
				});
        this.friends.forEach((el)=>{
          let channel = this.createChannelName(el.id,this.userData.id);
          Echo.join(channel)
          .listen('NewMessage', (e)=>{

            let authorExist = false;
            for(var i=0;i<this.messages.length;i++)
            {
              if(this.messages[i].author_id == e.sender_id)
              {
                this.messages[i].msg_created = e.msg_created;
                this.messages[i].message = e.message;
                authorExist = true
              }
            }

            if(!authorExist)
            {
              var index = -1;
              this.friends.forEach((el,i)=>{
                if(el.id == e.sender_id)
                  index = i
              });
              this.messages.unshift({
                message: e.message,
                author_id: e.sender_id,
                name: this.friends[index].name,
                surname: this.friends[index].surname,
                profile_img: this.friends[index].profile_img,
                msg_created: e.msg_created,
              })
            }
            this.showWindow = true;
            this.$emit('update-number',this.messages.length);
            this.notificationSoundPlay();
          })
        });
      });
    },
    notificationSoundPlay(){
      this.$refs.audio.play();
    },
    openWindow(){
      this.showWindow = !this.showWindow;
    },
    getProfileImgUrl(name){
      return '/storage/avatars/'+name;
    },
    shortenIfTooLong(text,num){
      if(text.length>num)
      {
        return text.substring(0,num)+"...";
      }
      return text;
    },
    viewMessage(author_id){
      this.chosenFriendId = author_id;
      this.$nextTick(() => {
  			this.$refs.goToMessages.submit();
  		});

    },
    getTimeDiffFromNow(time){
      let now = new Date();
      let then = new Date(time);
      then.setHours(then.getHours()+2);
      let diffrence = (now.getTime()-then.getTime())/1000;
      if (diffrence < 60)	return 'Przed chwilą';
      if (diffrence < 120)	return '1 minutę temu';

      for(let i=1;i<58;i++){
        if(i <= 3 || ((i % 10) <=3 && (i % 10) > 0 && i>20)){
          if (diffrence < 120 + parseInt(i*60))	return String(i+1)+' minuty temu';
        }else{
          if (diffrence < 120 + parseInt(i*60))	return String(i+1)+' minut temu';
        }
      }
      if(diffrence < 604800)
      {
        // console.log(now.getDate(),then.getDate());
        if(now.getDate() == then.getDate())
        {
          return 'Dzisiaj, '+("0"+then.getHours()).slice(-2)+':'+("0"+then.getMinutes()).slice(-2);
        }
        let yesterday = new Date();
        yesterday.setDate(yesterday.getDate()-1);
        if(then.getDate() == yesterday.getDate() && yesterday.getMonth())
        {
          return 'Wczoraj, '+("0"+then.getHours()).slice(-2)+':'+("0"+then.getMinutes()).slice(-2);
        }
        let day_before_yesterday = new Date();
        day_before_yesterday.setDate(day_before_yesterday.getDate()-2);
        if(then.getDate() == yesterday.getDate())
        {
          return 'Przedwczoraj, '+("0"+then.getHours()).slice(-2)+':'+("0"+then.getMinutes()).slice(-2);
        }else{
          let day_of_week = ''
          if(then.getDay() == 0) day_of_week = 'Niedziela';
          if(then.getDay() == 1) day_of_week = 'Poniedziałek';
          if(then.getDay() == 2) day_of_week = 'Wtorek';
          if(then.getDay() == 3) day_of_week = 'Środa';
          if(then.getDay() == 4) day_of_week = 'Czwartek';
          if(then.getDay() == 5) day_of_week = 'Piątek';
          if(then.getDay() == 6) day_of_week = 'Sobota';
          return day_of_week+" "+("0"+then.getHours()).slice(-2)+':'+("0"+then.getMinutes()).slice(-2);
        }
      }
        let formatted_date = then.getFullYear() + "-" + ("0"+String(then.getMonth()+1)).slice(-2) + "-" + ("0"+then.getDate()).slice(-2) + " " +("0"+then.getHours()).slice(-2)+':'+("0"+then.getMinutes()).slice(-2);
        return formatted_date
    },
    createChannelName(id1,id2){
      let channel_name = '';
      if(id1 < this.userData.id)
        channel_name = 'newmsg.'+String(id1)+'.'+String(id2);
      else
        channel_name = 'newmsg.'+String(id2)+'.'+String(id1);
      return channel_name
    },
  }
}
</script>
