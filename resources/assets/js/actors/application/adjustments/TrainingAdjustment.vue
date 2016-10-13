<template>
	<p>{{before.name}}</p>
	<p>{{{before.description}}}</p>
	
	<p>{{after.name}}</p>
	<p>{{{after.description}}}</p>

	<ul v-if="after.attached_teachers">
		Added : 
		<li v-for="teacher in after.attached_teachers">
			{{teacher}}
		</li>
	</ul>
	<hr>
	<ul v-if="after.detached_teachers">
		Removed :
		<li v-for="teacher in after.detached_teachers">
			{{teacher}}
		</li>
	</ul>
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