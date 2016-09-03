<template>
	<div class="column">
		<img :src="item.photos[0].url"/>
		<h3>{{item.name}}</h3>
		{{item.description}}	
		<ul>
			<li v-for="teacher in item.teachers">
				#{{teacher.username}},
			</li>
		</ul>	
	</div>
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