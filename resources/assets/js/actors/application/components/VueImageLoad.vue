<template>
	<div class="placeholder">
	  <img :src="smallImage" class="loaded img-small">
	  <div style="padding-bottom: 66.6%;"></div>
	</div>
</template>
<script type="text/javascript">
	export default {
		props : {
			smallImage : {
				type : String,
				required : true,
			},

			largeImage : {
				type : String,
				required : true,
			}
		}, 

		ready : function () {
			
			var imgLarge = new Image()
			imgLarge.src = this.largeImage	

			imgLarge.onload = function () {
				imgLarge.classList.add('loaded')
			    $('.placeholder .img-small').toggleClass('loaded')
			};

			var placeholder = document.querySelector('.placeholder')
			placeholder.appendChild(imgLarge)
		}
	}
</script>
<style type="text/css">
	.placeholder {
	  background-color: #f6f6f6;
	  background-size: cover;
	  background-repeat: no-repeat;
	  position: relative;
	  overflow: hidden;
	}

	.placeholder img {
	  position: absolute;
	  opacity: 0;
	  top: 0;
	  left: 0;
	  width: 100%;
	  transition: opacity 1s linear;
	}

	.placeholder img.loaded {
	  opacity: 1;
	}

	.img-small {
	  filter: blur(50px);
	  transform: scale(1);
	}
</style>