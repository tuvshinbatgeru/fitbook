<template>
	<h3>home default</h3>
</template>
<script>
	import FilterAble from '../../mixins/Filterable'
	
	export default {
		mixins : [FilterAble],

		props : {
			id : { 
				required: true,
			},

			isManager : {
				required: true,
			}
		},
	}

</script>