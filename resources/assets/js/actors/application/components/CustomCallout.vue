<template>
	<div v-show="!loading"
	     class="callout" 
	     :class="type | lowercase">
		<button v-show="closeable" class="callout__close" aria-label="Dismiss alert" type="button" data-close>
	    	<span aria-hidden="true">&times;</span>
	  	</button>
		<slot name="content">
		</slot>
	</div>

	<div v-show="loading" 
		 :style="'height:' + height + 'px;'"
		 :class="type | lowercase"
		 class="callout text-center">
		<div :class="spinnerType" class="preloader-wrapper active">
	      <div class="spinner-layer" :style="'border-color: ' + spinnerColor">
	        <div class="circle-clipper left">
	          <div class="circle"></div>
	        </div><div class="gap-patch">
	          <div class="circle"></div>
	        </div><div class="circle-clipper right">
	          <div class="circle"></div>
	        </div>
	      </div>
	    </div>
	</div>
</template>

<script>

	export default {
		props : {
			loading : {
				type: Boolean,
				default : false
			},
			
			type : {
				type: String,
				default : 'main'
			},
			
			borderRadius : {
				type: Number,
				default : 5,
			},

			spinnerType : {
				type: String,
				default : 'small',
			},

			spinnerColor : {
				type: String, 
				default : '#3f4652',
			},

			height : {
				type: Number,
				default : '300',
			},

			closeable : {
				type: Boolean,
				default : false,
			}
		},
	}
</script>

<style lang="scss">

.callout { 
	position: relative;
}

.callout__close {
	position: absolute;
	top : 0;
	right: 0;
}

.callout__base {
		background-color: #f6f9fa;
}

.callout {
	.preloader-wrapper {
		top: 45%;
	}

	.main {
		background-color: #fff;
	}

	.small {
		width: 20px;
	    height: 20px;
	}
	
	.medium {
		width: 32px;
		height: 32px;
	}

	.large {
		width: 64px;
		height: 64px;
	}
}


</style>