<template>
	<div class="plan-card" style="margin: 0 auto;">
	    <div class="plan-card-container">
	        <div class="plan-card-image">
	            <img :src="item.pinned_photos[0].url">
	            <div class="gradient-cover black-gardient">
				</div>
	            <div class="plan-statistic">
	                <div class="info">
	                    <i class="fa fa-heart"></i> {{item.hearts_actions_count}}
	                    <i class="fa fa-eye"></i> {{item.visitors_count}}
	                    <i class="fa fa-users"></i> {{item.subscriptions_count}}
	                    <span style="padding: 5px; background-color:#aecaec; color: #000; border-radius: 4px">
	                    	{{$t('loyalty')}}
	                    </span>
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
	        		<span style="font-size:11px;">{{item.created_at | moment "from"}} </span>
	        		<span style="font-size:11px;"></span>
	                <div class="club-name">
	                	<a :href="'/plan/' + item.id">
	                    	{{item.name}}
	                    </a>
	                </div>
	                <div class="plan-name">
	                	<span>@</span>
	                	<a>Flex Gym</a>
	                </div>
	            </div>
	            <div class="plan-detail">
	            	<div class="plan-date">
	            		<i class="fa fa-calendar"></i> {{item.planable.start_date}} - {{item.planable.finish_date}}
	            	</div>
	            	<div class="plan-price">
	            	<i class="fa fa-tag"></i> {{item.price}} - {{item.planable.before_price}}
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
</template>
<script>
	import CustomHexagon from '../../../svg/CustomHexagon.vue'

	export default {
		props : {
			item: {
				required : true
			}
		},

		components : {
			CustomHexagon
		}
	}
</script>