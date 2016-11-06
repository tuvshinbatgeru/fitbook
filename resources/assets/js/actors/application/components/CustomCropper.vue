<template>
	<div class="viewContainer">
        <div id="draggableContainer" 
        	 :style="
        	 	'top:' + horizontalPort + 'px;bottom:' 
        	 	+ horizontalPort + 'px;left:' 
        	 	+ verticalPort + 'px;right:' 
        	 	+ verticalPort + 'px;'
        	">
	    </div>
	    <img :id="id" class="pinned draggable" 
	         :style="axis == 'y' ? 'width:100%' : 'height:100%'"
	         :src = "image ? image.url : 'null'"/>
	    <div class="viewLabel" v-show="editable">
	    	<span>Drag to Reposition Cover</span>
	    </div>
	</div>
</template>
<script>
	export default {
		props : {
			ratio : {

			},
			mobileRatio : {

			},
			tabletRatio : {

			},
			image : {

			},
			top : {
				default : 0
			},
			left : {
				default : 0
			},
			editable : {

			}
		},

		data() {
			return {
				id : {},
				axis : "y",
				horizontalPort : 0,
				verticalPort : 0,
				width: 0,
				height: 0,
				mobileWidth : 760,
				tabletWidth : 900
			}
		},

		created : function () {
			this.id = this.$tools.newId()

			if(!this.tabletRatio) {
				this.tabletRatio = this.ratio
			}

			if(!this.mobileRatio) {
				this.mobileRatio = this.ratio
			}
		},

		ready : function () {

			$(window).resize(this.windowResize)
		    this.setDraggable()
		    this.reCalc()
		},

		watch : {
			image : function (oldValue, newValue) {
				this.reCalc()	
			},

			editable : function (oldValue, newValue) {
				this.setDraggable()
			}
		},

		methods : {
			reCalc : function () {
				this.axis = this.image.ratio <= 0.5 ? "x" : "y"
				this.setMargin()
				this.windowResize()
			},

			setDraggable:  function () {
				if(this.editable) {
					$("#" + this.id).draggable({
						axis: this.axis,
						containment:"#draggableContainer"
					})
				}
			},

			getViewPort : function () {
				if(this.axis == 'y') {
					var top = $('.draggable').css('top');
					top = -1 * parseInt(top.split('px')[0]);

					return {
						'top' : parseInt((top * 100) / (this.image.ratio * this.width)),
						'left' : 0,
					}
				} else {
					var left = $('.draggable').css('left');
					left = -1 * parseInt(left.split('px')[0]);

					return {
						'top' : 0,
						'left' : parseInt((left * 100) / (this.height / this.image.ratio))
					}
				}
			},

			setMargin : function () {
				this.left = 0
				this.top = 0

				if(this.image.pivot) {
					if(this.axis == "y") {
						this.top = this.image.pivot.top
					} else {
						this.left = this.image.pivot.left
					}
				}
			},

			setViewPort : function () {
				if(this.axis == 'y') {
					this.horizontalPort = this.height - this.width * this.image.ratio
					$('.draggable').css('top', (-1 * this.top * this.width * this.image.ratio) / 100)
				}
				else {
					this.verticalPort = this.width - (this.height / this.image.ratio)
					$('.draggable').css('left', (-1 * this.left * (this.height / this.image.ratio)) / 100)
				}
			},

			isMobile : function () {
				if(this.width <= this.mobileWidth) return true
				return false
			}, 

			isTablet : function () {
				if(this.mobileWidth > this.width && this.width <= this.tabletWidth) return true
				return false
			},

			isWeb : function () {
				if(this.width > this.tabletWidth) return true
				return false
			},

			windowResize : function () {
				this.width = $('.viewContainer').width()

				if(this.isMobile()) {
					this.height = this.width / this.mobileRatio
				}

				if(this.isTablet()) {
					this.height = this.width / this.tabletRatio
				}

				if(this.isWeb()) {
					this.height = this.width / this.ratio	
				}

				$('.viewContainer').css('height', this.height)
				this.setViewPort()
			}
		},
	}
</script>
<style lang="scss">
	.viewContainer {
		overflow:hidden;
		position: relative;
		height: 200px;
		width: 100%;
		background-color: #202b30;
	}

	#draggableContainer {
		left: 0px; 
		right: 0px; 
		position: absolute;
	}

	.draggable {
		position:relative; 
		max-height:none;
		max-width:none;
	}

	.pinned	{
		&:hover {
			cursor: move;
		}
	}

	.viewLabel {
		position: absolute;
		top: 50%;
		left: 20%;
		span {
		    background-color: rgba(84, 97, 133, .4);
		    border-radius: 5px;
			padding : 5px;
			color: #fff;
		}
	}

</style>