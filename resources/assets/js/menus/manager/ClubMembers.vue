<template>
  <div class="row small-up-3">
    <div class="column">
      <a class="button success">Teacher</a>
      <a class="button success">Trainer</a>
    </div>
  </div>
	<div>
		<h3>Club Members</h3>
		<div class="row small-up-3 medium-up-4 large-up-5">
			<div v-for="member in members">
				<div class="card column">
				    <!-- Header -->
				    <div class="card-header">
				      <div class="card-header__avatar" :style="{'background-image': 'url(' + member.avatar_url + ')'}"></div><a href="http://codepen.io/andytran" class="card-header__follow">Follow</a>
				    </div>
				    <!-- Content-->
				    <div class="card-content">
				      <div class="card-content__username">{{member.username}}
				      <span class="badge">{{member.pivot.type == 1 ? 'Manager' : 'Trainer'}}</span></div>
				      <div class="card-content__bio">Always looking for new knowledge :D.</div>
				    </div>
				    <!-- Footer-->
				    <div class="card-footer">
				      <div class="card-footer__pens"> <span>84</span>
				        <div class="ft-label">Pens</div>
				      </div>
				      <div class="card-footer__followers"> <span>986</span>
				        <div class="ft-label">Followers</div>
				      </div>
				      <div class="card-footer__following"> <span>33</span>
				        <div class="ft-label">Following</div>
				      </div>
				    </div>
			    </div>
			</div>
		</div>
	<div>
</template>

<script>
	export default {
		props: { 
			clubid : {},
		},

		data() {
			return {
				members : [],
			}
		},

		created: function () {
			this.init();
		},

		filter : {

		},

		methods : {
			init: function() {
				this.$http.get(this.$env.get('APP_URI') + 'api/club/edit/' + this.clubid + '/member').then((response) => 
				{
					this.members = response.data;
				}, (response) => {

				});			   
			},
		},
	}
</script>
	
<style lang="scss">

$white: #FFFFFF;
$black: #000000;
$dark-gray: lighten($black, 20%);
$gray: lighten($black, 40%);
$light-gray: lighten($black, 60%);

$primary: #303841;
$accent: #0781D7;

.card {
  background: $white;
  border-radius: 4px;
  box-shadow: 0 10px 20px rgba($black, 0.2);
  overflow: hidden;
  width: 300px;
  height: 100%;
  margin-bottom: 10px;

  &-header {
    position: relative;
    background: $primary;
    height: 200px;
    text-align: center;
    overflow: hidden;
    
    &__avatar {
      background: $primary;
      background-position: center 30%;
      background-size: 100%;
      height: 100%;
      width: 100%;
    }
    
    &__follow {
      position: absolute;
      top: 20px;
      right: 20px;
      background: $white;
      border-radius: 2px;
      box-shadow: 0 2px 4px rgba($black, 0.2);
      padding: 6px 10px;
      color: $dark-gray;
      font-size: 10px;
      font-weight: 600;
      line-height: normal;
      text-decoration: none;
      text-transform: uppercase;
    }
  }
  
  &-content {
    text-align: center;
    padding: 30px 20px;

    &__username {
      margin: 0 0 10px;
      color: $dark-gray;
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;

      .badge {
        display: inline-block;
        background: #FCD000;
        border-radius: 2px;
        margin: 0 10px 0;
        padding: 4px;
        color: $dark-gray;
        font-size: 10px;
        font-weight: 600;
        vertical-align: middle;
      }
    }
    
    &__bio {
      color: $gray;
      font-size: 12px;
    }
  }
  
  &-footer {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-between;
    background: #F3F3F3;
    padding: 15px 40px;
    color: $dark-gray;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    
    .ft-label {
      display: block;
      margin: 4px 0 0;
      color: $gray;
      font-size: 10px;
      font-weight: 400;
    }
  }
}

.code {
  background: rgba($black, 0.1);
  max-width: 600px; 
  border-radius: 2px;
  margin: 40px auto 100px;
  font-family: monospace;
  overflow: hidden;  
  overflow-x: auto;
  
  &:before {
    content: 'HTML Code';
    display: block;
    padding: 20px 20px 0;
    color: $dark-gray;
    font-weight: 600;
  }
}
</style>