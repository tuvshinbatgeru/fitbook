<template>
	<span v-for="item in visibleItems" v-html="itemText(item)">

	</span>
	<template v-if="total > limit">
		<div>
			<span v-text="limitBefore()"></span> <a @click="countClicked()">{{total - limit}}</a> <span v-text="limitAfter()"></span>
		</div>
    </template>
</template>

<script>

	export default {
		props : {
			limit : {
				type : Number,
				default : 9999,
			},
			
			total : {
				type : Number,
			},

			itemText : {
				type : Function,
				default : text => '${item}, '
			},

			limitBefore : {	
				type : Function,
				default: count => 'and '
			},

			limitAfter : {
				type : Function,
				default: after => ' others'
			},

			items : {
				required : true,
			}
		},

		methods : {
			itemTextDefault : function (item) {
				return item + ', ';
			},

			countClicked : function () {
				this.$emit('clicked');
			}
		},

		computed : {
			visibleItems () {
				return this.items.slice(0, this.limit);
			}
		},


	}
</script>