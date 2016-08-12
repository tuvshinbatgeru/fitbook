<script>
	export default {

		props: { 
			title : { default : 'test' },
		},

		data() {
			return {
				show: true,
			};
		},

		methods : {
			checkUserAvailable: function() {
				if(this.show)
				{
					this.$http.get(this.$env.get('APP_URI') + 'api/check-user/' + $('#username').val()).then((response) => 
					{
						response.data.result == 'no' ? $('#username').css('border','1px solid red') : $('#username').css('border','');
				    }, (response) => {

				    });
				}
			},
		}
	}
</script>