<template>
	<div class="multiselect__div">
		<span class="multiselect__tag"> 
			<span>{{tag.label}}</span> 
			<i @click="removeTag()" aria-hidden="true" tabindex="1" class="multiselect__tag-icon"></i> 
		</span>
	</div>
</template>

<script>

	export default {
		props : {
			tag : {}
		},

		methods : {
			removeTag : function () {
				this.$dispatch('removeTag', this.tag);
			}
		}
	}
</script>

<style lang="scss">
	.multiselect__div {
		padding:5px;
	}

	.multiselect__tag {
	    position: relative;
	    display: inline-block;
	    padding: 4px 26px 4px 10px;
	    border-radius: 5px;
	    margin-right: 10px;
	    color: #fff;
	    line-height: 1;
	    background: #41b883;
	    margin-bottom: 8px;
	    white-space: nowrap;
	}

	.multiselect__tag span {
		
	}

	.multiselect__tag-icon {
	    cursor: pointer;
	    margin-left: 7px;
	    position: absolute;
	    right: 0;
	    top: 0;
	    bottom: 0;
	    font-weight: 700;
	    font-style: initial;
	    width: 22px;
	    text-align: center;
	    line-height: 22px;
	    -webkit-transition: all .2s ease;
	    transition: all .2s ease;
	    border-radius: 5px;
	    outline: none;
	}
</style>