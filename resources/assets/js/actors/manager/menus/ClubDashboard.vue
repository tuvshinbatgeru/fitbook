<template>
	<div>
		<h3>Line</h3>
		<div id="chartdiv" style="width	: 100%; height : 500px;"></div>

		<custom-button :loading="true">follow</custom-button>
	<div>
</template>
<script>
	/*require('../../../dependency/amcharts')
	require('../../../dependency/serial')*/

	export default {
		props: { 
			clubid : {},
		},

		data() {
			return {

			}
		},

		ready: function () {
		}
    }
</script>
	
<style>
</style>