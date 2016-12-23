<template>
	<div class="Following__List">
		<ul>
			<li class="Following__Item" v-for="follow in following">
				<div class="row">
					<div class="small-4 columns">
			            <img src="/images/users/teacher_example.jpg" style="height:30px; width: 30px;" />
			        </div>
			        <div class="small-4 columns">
			            <p class="float-left">{{follow.followable.full_name}}</p>
			        </div>
			        <div class="small-4 columns">
			            <a v-bind:class="follow.state"  
			               class="button-follow"
			               @click="toggleState(follow)">{{$t(follow.state)}}</a>
			        </div>
				</div>
			</li>
		</ul>
	</div>
</template>
<script>
	import Paginateable from '../../application/mixins/Paginateable'
	import Loadable from '../../application/mixins/Loadable'


	export default {
		mixins : [Paginateable, Loadable],

		props : {
			userId : {
				required : true
			}
		},

		data () {
			return {
				following : []
			}
		},

		created : function () {
			this.getUserFollowing()
		},

		methods : {
			getUserFollowing : function () {
				this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.userId + '/following').then(res => {
					this.following = this.following.concat(res.data.result.data);

                    this.pageLast = res.data.result.last_page;
				}).catch(err => {

				});
			},

			toggleState : function (follow) {
				this.$http.post(this.$env.get('APP_URI') + 'api/user/' + this.userId + '/following?id=' + follow.followable_id + '&followable=' + follow.followable_type).then(res => {
					if(res.data.code == 0) {
				  		follow.state = res.data.result
				  		this.$emit('toggle', follow.state);
				  		return
				  	}

				  	this.$root.$refs.toast.showMessage(res.data.message);
				}).catch(err => {

				});
			}
		},

		locales: {
            en: { 
                follow : 'Follow',
                unfollow : 'Following',
            },
            mn : {
                follow : 'Дагах',
                unfollow : 'Дагасан',
            },
        }
	}
</script>
<style>
	.Following__List {
		font-size: 12px;
	}

	.Following__Item {
		border-bottom: 1px solid #eeeeee;
	}

	.button-follow {
        line-height: 24px;
        padding: 3px 10px;
        font-size: 12px;
        border-radius: 4px;
        border-style: solid;
        border-width: 1px solid ;
        font-weight: 600;
        outline: none;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 50%;
        -webkit-appearance: none;
    }

    .button-follow.unfollow {
        background-color: #5fcf80;
        color: #fff;
    }

    .button-follow.follow {
        background-color: #fff;
        color: #222222;
    }
</style>