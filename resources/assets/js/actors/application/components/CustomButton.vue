<template>
	<button class="button success" v-show="!loading">
        <slot>
        </slot>
	</button>

	<a class="button success" v-show="loading">
		<div class="preloader-wrapper small active">
	      <div class="spinner-layer spinner-green-only">
	        <div class="circle-clipper left">
	          <div class="circle"></div>
	        </div><div class="gap-patch">
	          <div class="circle"></div>
	        </div><div class="circle-clipper right">
	          <div class="circle"></div>
	        </div>
	      </div>
	    </div>
	</a>
</template>

<script>

	export default {
		props : {
			loading : {
				type: Boolean,
				default : false
			},
			text : {
				type : String,
				required : true,
				default : '',
			}
		},
	}
</script>

<style>
</style>