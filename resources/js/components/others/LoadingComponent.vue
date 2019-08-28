<template>
	<div>
		<div class="loader">
			<div class="spinner"></div>
		</div>
	</div>
</template>

<style scoped>
.loader{
	position: absolute;
	left:0;
	top:0;
	background-color: rgba(200,200,200,0.4);
	z-index: 10;
	width: 100%;
	height: 100%;
}
.spinner {
	position: absolute;
	top:50%;
	left: 50%;
	margin-top: -7vh;
	margin-left: -5vh;
  height: 10vh;
  width: 10vh;
  border: 6px solid rgba(0, 174, 239, 0.2);
  border-top-color: rgba(0, 174, 239, 0.8);
  border-radius: 100%;
  animation: rotation 0.6s infinite linear 0.25s;

  /* the opacity is used to lazyload the spinner, see animation delay */
  /* this avoid the spinner to be displayed when visible for a very short period of time */
  opacity: 0;
}

@keyframes rotation {
  from {
    opacity: 1;
    transform: rotate(0deg);
  }
  to {
    opacity: 1;
    transform: rotate(360deg);
  }
}

</style>