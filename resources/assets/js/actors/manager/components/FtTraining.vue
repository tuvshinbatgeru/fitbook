<template>
	<li style="border: 1px solid green;">
		<img :src="item.photos[0].url"/>
		<h3>{{item.name}}</h3>
		{{item.description}}	
		<ul>
			<li v-for="teacher in item.teachers">
				#{{teacher.username}},
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