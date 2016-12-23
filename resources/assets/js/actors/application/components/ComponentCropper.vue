<template>
	<div style="max-width: 100%;">
        <vue-cropper
            v-ref:cropper
            :guides="true"
            :aspect-ratio = "ratio"
            :view-mode="2"
            drag-mode="move"
            :auto-crop-area="0.5"
            :min-container-width="258"
            :min-container-height="192"
            :background="true"
            :rotatable="true"
            :src="image">
        </vue-cropper>
    </div>

    <!-- <button @click="cropImage">Crop Image</button> -->
    <a @click="rotateDegree(15)">
    	<i class="fa fa-share"></i>
    </a>
    <a @click="setScaleX"><i class="fa fa-refresh"></i></a>
    <a @click="setScaleY"><i class="fa fa-refresh"></i></a>

</template>
<script>
	export default {
		props : {
			image : {
				required : true
			},
			ratio : {

			},
		},

		data () {
			return {
				scaleX : -1,
				scaleY : -1,
			}
		},

		methods : {
			rotateDegree : function (degree) {
				this.$refs.cropper.rotate(degree)
			},
			setScaleX : function () {
				debugger
				this.$refs.cropper.scaleX(this.scaleX)
				this.scaleX *= -1
			},
			setScaleY : function () {
				this.$refs.cropper.scaleY(this.scaleY)
				this.scaleY *= -1
			}
		}
	}
</script>