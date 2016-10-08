<template>
	<p>{{before.name}}</p>
	<p>{{{before.description}}}</p>
	<hr>
	<p>{{after.name}}</p>
	<p>{{{after.description}}}</p>
</template>

<script>

	export default {
		props : {
			before : {},
			after : {}
		},

		ready : function () {
			this.before = JSON.parse(this.before);
			this.after = JSON.parse(this.after);
		},
	}
</script>