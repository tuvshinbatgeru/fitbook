<script>
	export default {

		props: { 
			title : { default : 'test' },
		},

		created: function () {

		},

		ready: function () {
			var burger = document.querySelector('.burger-container'),
	        header = document.querySelector('.header');
	    
		    burger.onclick = function() {
		        header.classList.toggle('menu-opened');
		    }
		},

		methods : {
			loginAsFacebook : function() {
				/*this.$http.get('http://127.0.0.1/login/facebook', { headers: { 'Access-Control-Allow-Origin': true }}).then((response) => 
				{
					debugger;
			    	alert(response.data.result);
			    }, (response) => {

			    });*/
			},

			signUp: function() {
			   
			} 


		}
	}
</script>