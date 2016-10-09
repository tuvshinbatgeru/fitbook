<template>
	<div class="logout__menu">
		Membership clubs
	    <br>
	    <ul>
		    <li v-for="menu in menus">
		    	<img src="/images/1470464066.png" style="height:32px; width:32px;" />
		        <a :href="'/' + menu.club_id + '/edit'">
		          {{menu.short_name}} as Manager
		        </a>
		    </li>
	    </ul>
	    Subscriptions 
	    <br>
	    <ul>
	    	<li v-for="subscription in subscriptions">
	    		<img :src="subscription.pinned_photos[0].url" style="height:32px; width:32px;" />
	    		<a>{{subscription.name}}</a>
	    		<span style="padding:5px; border-radius:4px; background-color:red; color:white;">{{subscription.pivot.end_date | dayDiffFromNow}}</span>days left
	    	</li>
	    </ul>
	    <a href="/auth/logout">Log out</a>  
	</div>
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

		filters : {
			dayDiffFromNow : function (from) {
				return Vue.moment(from, 'YYYY-MM-DD').diff(Vue.moment(), 'days');
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
<style type="text/css">
	.logout__menu {
		font-size:12px;
	}
</style>