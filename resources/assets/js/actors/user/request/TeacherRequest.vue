<template>
	<div class="request">
		<h4>Request</h4>
		<a>Mark as read</a>
	</div>
</template>

<script>
	export default {
		props: {
			request : {
				required : true
			},
		},
	}
</script>