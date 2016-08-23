<template>
	<div class="progress--circle" v-bind:class="percentageClass">
	  <div class="progress__number">{{percentage}}%</div>
	</div>
</template>

<script>
	export default {
		props: {
			height: {
				type : Number,
				default : 50,
			},

			url : {
				type : String, 
				default : function () {
					return "http://localhost/images/users/teacher_example.jpg";
				}
			},

			width: {
				type : Number,
				default : 50,
			},

			colors: {
				type : Array,
				default : function () {
					return ['#5fcf80', '#ffae00', '#ec5840'];
				}
			},

			percentage : {
				type : Number,
				required : true,
			}
		},

		computed: {
			percentageClass () {
			  	return "progress--" + this.percentage;
			},
			
			percentageColor () {
				if(this.percentage > 50)
					return this.colors[0];
				if(this.percentage > 80)
					return this.colors[1];
				return this.colors[2];
			}
		}
	}
</script>
<style lang="scss">

$spacing: 1rem;
$themeColor: #63B8FF;
$backColor: #ddd;
$textShadow: rgba(black, 0.35) 1px 1px 1px;

.progress--circle {
  position: relative;
  display: inline-block;
  margin: $spacing;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background-color: $backColor;
  &:before {
    content: '';
    position: absolute;
    top: 15px;
    left: 15px;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background-color: white;
  }
  &:after {
    content: '';
    display: inline-block;
    width: 100%;
    height: 100%;
    border-radius: 50%; 
    background-color: $themeColor;
  }
}

.progress__number {
  position: absolute;
  top: 50%;
  width: 100%;
  line-height: 1;
  margin-top: -0.75rem;
  text-align: center;
  font-size: 1.5rem;
  color: #777;
}

$step: 1;
$loops: round(100 / $step);
$increment: 360 / $loops;
$half: round($loops / 2);
@for $i from 0 through $loops {
  .progress--bar.progress--#{$i * $step}:after {
    width: $i * $step * 1%;
  }
  .progress--circle.progress--#{$i * $step}:after {
    @if $i < $half {
      $nextDeg: 90deg + ($increment * $i);
      background-image: linear-gradient(90deg, $backColor 50%, transparent 50%, transparent), linear-gradient($nextDeg, $themeColor 50%, $backColor 50%, $backColor);
    }
    @else {
      $nextDeg: -90deg + ($increment * ($i - $half));
      background-image: linear-gradient($nextDeg, $themeColor 50%, transparent 50%, transparent), linear-gradient(270deg, $themeColor 50%, $backColor 50%, $backColor);
    }
  }
}

</style>