<template>
	<div class="Slide__Container">
	<div id="Horizontal__Slide" class="Horizontal__Slide">
		<button v-show="indexMuch()" @click="moveLeft()" class="Horizontal__Left">
		    <i class="fa fa-chevron-left"></i>
		</button>

	    <button v-show="(index * step + block) < items.length" @click="moveRight()" class="Horizontal__Right">
	    	<i class="fa fa-chevron-right"></i>
	    </button>
		<div class="Horizontal__Window" :style="'left:-' + moveLength + 'px'">
		    <div :style="'width:' + moveWidth + 'px;'" class="Horizontal__Content" v-for="item in items">
		    	<component :item="item" :is="item.context">
		    		
		    	</component>
		    </div>
    	</div>
    </div>
    </div>
</template>
<script>
	import PrimaryPlanContext from './context/PrimaryPlanContext.vue'
	import LoyaltyPlanContext from './context/LoyaltyPlanContext.vue'

	export default {
		props: {
			step : {
				default : 1
			},

			slideWidth : {
				default: 258
			},

			items: {

			},
		},

		data () {
			return {
				index : 0,
				windowWidth : null,
			}
		},

		ready : function () {
		    Hammer(document.getElementsByClassName("Horizontal__Window")[0]).on("swipeleft", this.moveRight);
		    Hammer(document.getElementsByClassName("Horizontal__Window")[0]).on("swiperight", this.moveLeft);

		    $(window).resize(this.windowResize)
		    this.windowResize()
		},

		methods : {
			windowResize : function () {
				this.windowWidth = $('.Horizontal__Slide').width()
			},

			setIndex(temp) {
				this.index = temp
			},

			moveLeft : function () {
				if(this.index > 0)
					this.index -= this.step
			},

			moveRight : function () {
				if((this.index * this.step + this.block) < this.items.length)
					this.index += this.step 
			},

			indexMuch : function () {
				return this.index > 0
			},
		},

		computed : {
			block : function () {
				return Math.floor(this.windowWidth / this.slideWidth);
			},

			moveLength : function () {
				return (this.index * this.moveWidth - this.marginLength)
			},

			marginLength : function () {
				return (this.windowWidth % (this.block * this.slideWidth)) / (this.block + 2)
			},

			moveWidth : function () {
				return  this.slideWidth + this.marginLength
			}
		},

		components : {
			PrimaryPlanContext, LoyaltyPlanContext
		}
	}
</script>
<style lang="scss">
.Slide__Container {
	position: relative;
	height: 330px;
	width: 100%;
	padding: 0px;
	margin: 0px;
}
.Horizontal__Slide {
	position: relative;
	height: 330px;
	width: 100%;
	overflow: hidden;
}

.Horizontal__Window {
	position: absolute;
	width: 3000px;
	left: 0px;
	top: 0;	
	padding-top: 10px;
	-webkit-transition: all 500ms cubic-bezier(0.470, 0.000, 0.745, 0.715); 
   -moz-transition: all 500ms cubic-bezier(0.470, 0.000, 0.745, 0.715); 
     -o-transition: all 500ms cubic-bezier(0.470, 0.000, 0.745, 0.715); 
        transition: all 500ms cubic-bezier(0.470, 0.000, 0.745, 0.715); /* easeInSine */
}

.Horizontal__Content {
	display: inline-block;
	width: 292px;
	height: 300px;
	color : #fff;
}

.Horizontal__Left {
    position: absolute;
    top: 135px;
    left: 0px;
    z-index: 10;
    color: #bdbdbd;
    width: 50px;
    text-align: center;
    height: 80px;
    line-height: 80px;
    border-radius: 5px;
    background-color: rgba(0, 0, 0, 0.46);
    font-size: 30px;
    -webkit-transition: all 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715); 
   -moz-transition: all 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715); 
     -o-transition: all 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715); 
        transition: all 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715); /* easeInSine */
    &:hover {
    	color: #eee;
    }
}

.Horizontal__Right {
	position: absolute;
    top: 135px;
    right: 0px;
    z-index: 10;
    color: #bdbdbd;
    width: 50px;
    text-align: center;
    height: 80px;
    line-height: 80px;
    border-radius: 5px;
    background-color: rgba(0, 0, 0, 0.46);
    font-size: 30px;
    -webkit-transition: all 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715); 
   -moz-transition: all 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715); 
     -o-transition: all 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715); 
        transition: all 300ms cubic-bezier(0.470, 0.000, 0.745, 0.715); /* easeInSine */
    &:hover {
    	color: #eee;
    }
}
</style>