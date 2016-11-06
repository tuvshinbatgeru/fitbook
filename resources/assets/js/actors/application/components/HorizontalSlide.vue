<template>
	<div class="Slide__Container">
	<button v-show="index > 0" @click="moveLeft()" class="Horizontal__Left"
		:style="'left: ' + ((windowWidth / block - slideWidth)/2 - 50) + 'px;'">
	    <i class="fa fa-chevron-left"></i>
	</button>

    <button v-show="(index * step + block) < items.length" @click="moveRight()" class="Horizontal__Right" :style="'right: ' + ((windowWidth / block - slideWidth)/2 - 50) + 'px;'">
    	<i class="fa fa-chevron-right"></i>
    </button>
	<div id="Horizontal__Slide" class="Horizontal__Slide">
		<div class="Horizontal__Window" :style="'left:-' + (index * (windowWidth / block)) + 'px'">
		    <div :style="'width:' + ((windowWidth / block)) + 'px;'" class="Horizontal__Content" v-for="item in items">
		    	<div class="plan-card" style="margin: 0 auto;">
                    <div class="plan-card-container">
                        <div class="plan-card-image">
                            <img src="http://localhost/images/users/91f5060e20b1d98a49b35d974dca573f1477461676Nuur huudas new 7.gif">
                            <div class="gradient-cover black-gardient">
    						</div>
                            <div class="plan-statistic">
                                <div class="info">
                                    <i class="fa fa-heart"></i> 350
                                    <i class="fa fa-eye"></i> 401
                                </div>
                            </div>
                        </div>
                        <div class="plan-card-info">
                        	<div class="club-profile-picture">
                        		<svg style="display: block; width: 80px;height: 70px;">
						          <defs>
						          	<pattern id="prof-img" patternUnits="userSpaceOnUse" width="100%" height="100%">
							            <image preserveAspectRatio="none" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="http://i.imgur.com/uTDpE6J.jpg" width="100%" height="100%"></image>
							        </pattern>
						            <filter id="dropshadow" height="130%">
						              <feGaussianBlur in="SourceAlpha" stdDeviation="3"/> 
						              <feOffset dx="0" dy="0" result="offsetblur"/>
						              <feComponentTransfer>
						                <feFuncA type="linear" slope="0.2"/>
						              </feComponentTransfer>
						              <feMerge> 
						                <feMergeNode/>
						                <feMergeNode in="SourceGraphic"/> 
						              </feMerge>
						            </filter>
						            <linearGradient id="linear" x1="0%" y1="0%" x2="0%" y2="100%">
						              <stop offset="0%"   stop-color="#fff"/>
						              <stop offset="100%" stop-color="#afafaf"/>
						            </linearGradient>
						          </defs>
						              <custom-hexagon
						                bg-color="url('#prof-img')" 
						                filter-id="url('#dropshadow')"
						                border-color="url('#linear')"
						                :border-width="2"
						                :length="40" 
						                :cord-x="0" 
						                :cord-y="0">
						              </custom-hexagon>
						        </svg>
                        	</div>
                        	<div class="title-container">
	                            <div class="club-name">
	                            	<a>
	                                	Flex gym
	                                </a>
	                            </div>
	                            <div class="plan-name">
	                            	<a>
	                                	Summer and Winter plan
	                                </a>
	                            </div>
                            </div>
                            <div class="plan-detail">
                            	<div class="plan-date">
                            		<i class="fa fa-calendar"></i> Oct 31 - Nov 21
                            	</div>
                            	<div class="plan-price">
                            	<i class="fa fa-tag"></i> 180,000 - 200,000
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
		    </div>
    	</div>
    </div>
    </div>
</template>
<script>
	import CustomHexagon from '../svg/CustomHexagon.vue';

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
		},

		computed : {
			block : function () {
				return Math.floor(this.windowWidth / this.slideWidth);
			},
		},

		components : {
			CustomHexagon
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
	left: 0;
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
    top: 199px;
    left: -36px;
    z-index: 0;
    color: #f04545;
    width: 50px;
    text-align: center;
    height: 90px;
    line-height: 90px;
    border-top: 1px solid #959595;
    border-left: 1px solid #959595;
    border-bottom: 1px solid #959595;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    background-color: #fff;
    font-size: 30px;
    padding-right: 15px;

}

.Horizontal__Right {
	position: absolute;
    top: 199px;
    right: -36px;
    z-index: 0;
    color: #f04545;
    width: 50px;
    text-align: center;
    height: 90px;
    line-height: 90px;
    border-top: 1px solid #959595;
    border-right: 1px solid #959595;
    border-bottom: 1px solid #959595;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    background-color: #fff;
    font-size: 30px;
    padding-left: 15px;

}
</style>