<template>
	<h3>{{club.full_name}}</h3>
	<p>{{club.description}}</p>
	<img :src="club.cover_with_logo | cover"/>
</template>
<script>
	export default {
		props : {
			id : {
				required : true
			}
		},

		data () {
			return {
				club : {}	
			}
		},

		created : function () {
			this.getClubHeader()
		},

		filters : {
			cover : function (photos) {
				if(photos && photos.length > 0) {
					return photos[0].url
				}
				return this.$env.get('APP_URI') + 'images/site/default_club_cover.jpg'
			}
		},

		methods : {
			getClubHeader : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/edit/' + this.id + '/headerinfo').then(res => {
				  	this.club = res.data.result
				}).catch(err => {
				  	
				});
			}
		}
	}
</script>