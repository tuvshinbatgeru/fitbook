<template>
	<li style="border: 1px solid green;">
		<h3>{{item.name}}</h3>
		{{item.description}}	
		<ul>
			<li v-for="teacher in item.teachers">
				#{{teacher.username}},
			</li>
		</ul>	
		<ul>
			
			<li v-for="photo in item.photos">
				<img height="100" width="100" v-bind:src="photo.url"/>
			</li>
			
		</ul>	
	</li>
</template>

<script>
	export default {
		props: {
			item : {}
		},
	}
</script>
<style>
</style>