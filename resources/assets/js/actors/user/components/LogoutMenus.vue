<template>
	Your clubs 
    <br>
    <ul>
	    <li v-for="menu in menus">
	        <a :href="'/' + menu.club_id + '/edit'">
	          {{menu.short_name}}
	        </a>
	    </li>
    </ul>
    Subscriptions 
    <br>
    <ul>
    	<li v-for="subscription in subscriptions">
    		<a>{{subscription.name}}</a>		
    	</li>
    </ul>
    <a href="/auth/logout">Log out</a>  
</template>
<script>
	export default {
		props : {
			userId : {
				required : true
			}
		},

		data () {
			return {
				menus : [],
				subscriptions : [],
			}
		},

		created : function () {
			this.getUserMenus();
		},

		methods : {
			getUserMenus: function () {
				debugger;
				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.userId + '/menus').then(res => {
					this.menus = res.data.menus;
					this.subscriptions = res.data.subscriptions;
				}).catch(err => {
				  
				});
			}
		}
	}
</script>