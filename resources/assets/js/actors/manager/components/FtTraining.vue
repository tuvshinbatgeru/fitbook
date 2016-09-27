<template>
	<div class="column">
		<div class="ft-pinned">
            <img v-lazy="item.pinned_photos[0].url"
                 :style = "{ 
                        top: -1 * parseInt((item.pinned_photos[0].pivot.top_percentage * 300 * item.pinned_photos[0].ratio) / 100) + 'px'
                 }" />    
        </div>
		

		<h3>{{item.name}}</h3>
		{{{item.description}}}	
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
.ft-pinned {
	width:300px; 
	height:100px; 
	overflow: hidden;
} 

.ft-pinned img {
	width: 100%;
	position: relative;
	max-height: none;
}
</style>