<template>
	<div class="member-card">
		<a class="member-img">
			<div class="cover-img">
				<img class="horizontal" :src="member.avatar_url" />
				<span :class="member.is_online ? 'online' : ''"></span>
			</div>
		</a>
		<div class="member-info">
			<div class="_info">
				<label class="_name">
					<a :href="'/users/' + member.username">{{member.first_name}} {{member.last_name}}</a>
				</label>
				<a class="_follow">{{member.followers_count}} followeres</a>
				<i class="fa fa-circle"></i>
				<a class="_follow">{{member.following_count}} following</a>
			</div>
			<div class="follow-btn">
				<a class="fit-hollow-btn" v-show="false">
					+ {{$t('follow')}}
				</a>
				<a class="fit-hollow-btn">
					{{$t('fending')}}
				</a>
				<a class="fit-hollow-btn" v-show="false">
					{{$t('teacher')}}
				</a>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		props : {
			member : {
				type: Object,
				required : true
			}
		},

		locales : {
			en : {
				follow : 'Follow',
				teacher : "Teacher",
				manager : "Manager",
				reception : "Reception",
				fending : "Fending ...",
				fired : "You're fired"
			},
			mn : {
				follow : 'Дагах',
				teacher : "Багш",
				manager : "Менежер",
				reception : "Ресефшен",
				fending : "Илгээсэн ...",
				fired : "Ажлаас чөлөөлөх"
			}
		}
	}
</script>