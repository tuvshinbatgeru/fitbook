<template>
	<div id="Horizontal__Slide" class="Horizontal__Slide">
		<button v-show="index > 0" @click="moveLeft()" class="Horizontal__Left">
		    <i class="fa fa-arrow-left"></i>
		</button>

	    <button v-show="(index * step + block) < items.length" @click="moveRight()" class="Horizontal__Right">
	    	<i class="fa fa-arrow-right"></i>
	    </button>

		<div class="Horizontal__Window" :style="'left:-' + (index * (windowWidth / block)) + 'px'">
		    <div :style="'width:' + ((windowWidth / block)) + 'px;'" class="Horizontal__Content" v-for="item in items">
		    	<div class="plan-card" style="margin: 0 auto;">
                    <div class="plan-card-container">
                        <div class="plan-card-image">
                            <img src="http://localhost/images/users/91f5060e20b1d98a49b35d974dca573f1477461676Nuur huudas new 7.gif">
                        </div>
                        <div class="plan-card-info">
                            <div class="club-name">
                                Flex gym
                            </div>
                            <div class="plan-name">
                                Summer and Winter plan
                            </div>
                            <div class="plan-statistic">
                                <div class="info">
                                    <i class="fa fa-heart"></i> 350
                                    <i class="fa fa-eye"></i> 401
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="plan-price">
                        140,000 ₮
                    </div>
                </div>
		    </div>
    	</div>
    </div>
</template>
<script>
	export default {
		props: {
			step : {
				default : 1
			},

			slideWidth : {
				default: 247
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
		},

		computed : {
			block : function () {
				return Math.floor(this.windowWidth / this.slideWidth);
			},
		}
	}
</script>
<style lang="scss">
.Horizontal__Slide {
	position: relative;
	height: 300px;
	width: 100%;
	overflow: hidden;
}

.Horizontal__Window {
	position: absolute;
	width: 3000px;
	left: 0;
	top: 0;	
	-webkit-transition: all 300ms ease-out;
	-moz-transition: all 300ms ease-out;
	-ms-transition: all 300ms ease-out;
	-o-transition: all 300ms ease-out;
	transition: all 300ms ease-out;
}

.Horizontal__Content {
	display: inline-block;
	width: 292px;
	height: 300px;
	color : #fff;
}

.Horizontal__Left {
	position: absolute; 
	top: 50%; 
	left:0;
	z-index : 10;
}

.Horizontal__Right {
	position: absolute; 
	top: 50%; 
	right:0;
	z-index : 10;
}
</style>