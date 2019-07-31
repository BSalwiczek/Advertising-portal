<style scoped>
@import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
</style>

<template>
	<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut fast">
		<div class="col-lg-4 col-md-12 mt-5">
		<div class="type text-center">
				<div class="p-0 text-right mr-3">
					<i @click="$emit('delete-mtc')" class="fas fa-trash-alt trash shake"></i>
				</div>

				<textarea required v-validate type="text" class="form-control mt-2 px-3" style="font-size: 1.4em" ref="massageType" name="massageType" placeholder="Nazwa masażu" :value="value.name" @input="updateData()"></textarea>
				<span class="error">{{ errors.first('massageType') }}</span>

				<!-- <img class="img-fluid" src="/storage/massage_types/classic.jpg"> -->
				<div>
					<div class="img-container mt-3">
						<img class="img-fluid d-flex" :src="image">
						<input type="file" v-validate="'image'" name="image" style="display: none" ref="fileInput" @change="onFileChange($event)">
						<div class="positioning" @click="$refs.fileInput.click()"><div class="upload"><i class="fas fa-upload"></i></div></div>
					</div>
					<span class="error">{{ errors.first('image') }}</span>

				</div>
				

				<textarea required v-validate class="form-control mt-3 px-3" name="massageDesc" ref="massageDesc" id="massageDesc" :value="value.description" placeholder="Tutaj zamieść krótki opis masażu..." @input="updateData()"></textarea>
				<span class="error">{{ errors.first('massageDesc') }}</span>


				<div class="d-flex mt-4 w-75 mx-auto" style="font-size: 1.3em">
					<div class="my-auto">
						<input required v-validate="'required|numeric'" type="text" ref="price" name="price" @input="updateData()" :value="value.price" class="form-control" placeholder="cena">
						<span class="error">{{ errors.first('price') }}</span>
					</div>
					<div class="my-auto ml-2">
						PLN
					</div>
				</div>

				<input required v-validate ref="duration" type="text" @input="updateData()" :value="value.duration" class="form-control w-50 mx-auto mt-2" name="duration" placeholder="Czas trwania">
				<span class="error">{{ errors.first('duration') }}</span>
			
		</div>

	</div>
		
	</transition>
</template>

<style scoped>
.type{
	background-color: #F5FCFF;
	padding: 2em 0;
	padding-top: 0.7em;
	border-top: 5px solid #53C5F7;
	-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.12);
	-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.12);
	box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.12);
}
textarea,input{
	border-color: #F5FCFF;
	background-color: #F5FCFF;
	border-width: 1px;
	padding:0.5em;
	box-shadow: none;
	outline: none;
	font-size: 1.1em;
	resize: none;
	text-align: center;
}
.trash{
	color: #333;
}
.trash:hover{
	color: red;
	cursor: pointer;
	animation: shake 0.2s; 
}

@keyframes shake {
  0% { transform: translate(1px, 1px) rotate(0deg); }
  20% { transform: translate(-3px, 0px) rotate(1deg); }
  40% { transform: translate(1px, -1px) rotate(1deg); }
  60% { transform: translate(-3px, 1px) rotate(0deg); }
  80% { transform: translate(-1px, -1px) rotate(1deg); }
  100% { transform: translate(1px, -2px) rotate(-1deg); }
}
.img-container {
    display: inline-block;
    position: relative;
}
.positioning{
  	position: absolute;
  	font-size: 1.5em;
	top: 50%;
  	left: 50%;
  	transform: translate(-50%, -50%);
  	background-color: #ddd;
  	opacity: 0.4;
  	transition: all 0.2s;
  	width: 100%;
  	height: 100%;
  	text-align: center;
}
.positioning:hover{
	opacity: 0.6;
	cursor: pointer;
	font-size: 1.9em;
	transition: all 0.2s;
}
.upload{
  	position: absolute;
	top: 50%;
  	left: 50%;
  	transform: translate(-50%, -50%);
}


</style>

<script type="text/javascript">
	export default{
		props:['value'],
		data(){
			return {
				selectedFile: null,
				image: '/storage/massage_types/classic.jpg',
				file: {},
				user_fields: {},
			}
		},
		methods: {
			updateData(){
				this.$emit('input',{
					id: this.value.id,
					name: this.$refs.massageType.value,
					description: this.$refs.massageDesc.value,
					price: this.$refs.price.value,
					duration: this.$refs.duration.value,
					image: this.file,
				});
				// console.log(this.value)
			},
			onFileChange(e) {
		      var files = e.target.files || e.dataTransfer.files;
		      if (!files.length)
		        return;
		 	  this.file = files[0];
		      this.createImage(files[0]);
		    },
		    createImage(file) {
		      var image = new Image();
		      var reader = new FileReader();

		      reader.onload = (e) => {
		        this.image = e.target.result;
		      };
		      reader.readAsDataURL(file);
		      this.value.image = this.file;
		      this.updateData();
		    },

		},
	}
</script>