<template>
	<div class="row text-center" style="padding:10px; font-size:12px;">
		<a href="/plan/15#7"><i>flexgym - Намрын урамшуулал</i></a>
		<br>

		<a>{{mention.mentioned.created_at | moment "from" }}</a>
		
		<div>
			{{{ mention.mentioned.message }}}
		</div>

		<a>Mark as read</a>
	</div>
	<hr>
</template>

<script>
	export default {
		props: {
			mention : {
				required : true
			},
		},
		
		methods : {

		},
	}
</script>
<style>
</style>