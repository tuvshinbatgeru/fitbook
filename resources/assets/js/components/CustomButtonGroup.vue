<template>
	
	<ul class="group-button">
		<li>
			<a @click="setSelected(current.value)" :class="current.value == value ? 'selected' : ''" v-for="current in data">
				{{current.name}}
			</a>
		</li>
	</ul>
	
</template>

<script>
	export default {
		props: {
			layout : { 
				type : String,
				default : 'horizontal',
			},
			data : {
				required : true
			},

			value : {
				default : 0
			}
		},

		methods : {
			setSelected : function(value) {
				this.value = value;
			}
		}
	}
</script>


<style lang="scss">
	$group-button-green : #3adb76;

	@mixin transition($time) {
	-webkit-transition: all $time ease;
	-moz-transition: all $time ease;
	-ms-transition: all $time ease;
	-o-transition: all $time ease;
	transition: all $time ease;
	}

	.group-button {
		a:first-child {
			border-top-left-radius: 1000px;
			border-bottom-left-radius: 1000px;
		}

		a {
			border-color: $group-button-green;
			background-color: #fff;
			border: 1px solid $group-button-green;
			padding: 5px 7px;
			text-align: center;
			color: $group-button-green;
			margin-left: -1px;

			@include transition(500ms);

			&:hover {
				background-color: $group-button-green;
				color: #fff;
			}

			&.selected {
				background-color: $group-button-green;
				color: #fff;
				font-weight: bold;
			}
		}

		a:last-child {
			border-top-right-radius: 1000px;
			border-bottom-right-radius: 1000px;
		}
	}
</style>