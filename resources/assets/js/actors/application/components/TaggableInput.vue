<template>
	<div class="multiselect__tags">
		<span class="multiselect__tag">
			<input value="Test" />
		</span>
		<span class="multiselect__tag">
			<input value=" " />
		</span>
		<span>
			<input value="Value" />
		</span>
	</div>
</template>

<script>
	export default {
		props : {
			debounce : {
				default : 300,
			},

			tags : {

			},

			input : {},
		},
	}
</script>

<style>

.multiselect__tags {
  min-height: 40px;
  display: block;
  padding: 8px 40px 0 8px;
  border-radius: 5px;
  border: 1px solid #E8E8E8;
  background: #fff;
}

.multiselect__tag ~ .multiselect__input {
  width: auto;
}

</style>