<template>
	<div v-show="!loading" v-if="!blank" class="callout primary">
		<slot>
		</slot>
	</div>

	<div v-show="loading" v-if="!blank" class="callout secondary">
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
	</div>
</template>

<script>

	export default {
		props : {
			loading : {
				type: Boolean,
				default : false
			},

			blank: {
				type: Boolean,
				default : true,
			}
		},
	}
</script>

<style>
</style>