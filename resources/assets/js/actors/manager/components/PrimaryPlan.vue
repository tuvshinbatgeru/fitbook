<template>
    <div class="row small-up-1 large-up-2" style="font-size:12px;">
        <div class="columns" v-for="current in plans">
        <h3><a href="/plan/22">{{current.plan[0].name}}</a></h3>
        <div>
            <span class="fa fa-user" style="color: #3f4652"></span>
            <strong>13/7</strong>

            <span class="float-right">{{current.plan[0].created_at | moment "from"}}</span>
        </div>
        <div class="row text-center">
            <span class="fa fa-heart" style="color: red;"></span>
            <strong>{{current.plan[0].hearts_actions_count}}</strong>

            <span class="fa fa-comments-o" style="color: #3f4652;"></span>
            <strong>{{current.plan[0].comments_count}}</strong>

            <span class="fa fa-eye"></span>
            <strong>1270</strong>
        </div>
        <p>{{{current.plan[0].description}}}</p>

        <div style="width:300px; height:100px; overflow: hidden;">
            <img v-lazy="current.plan[0].pinned_photos[0].url"
                 style="width: 100%;
    position: relative;
    max-height: none;" 
                 :style = "{ 
                        top: -1 * parseInt((current.plan[0].pinned_photos[0].pivot.top_percentage * 300 * current.plan[0].pinned_photos[0].ratio) / 100) + 'px'
                 }" />    
        </div>
            
        <label>{{current.plan[0].price}}</label>

        <ul v-for="teacher in current.plan[0].teachers">
            {{teacher.username}}
        </ul>
        <ul v-for="service in current.plan[0].services">
            {{service.name}}
        </ul>
        <ul v-for="train in current.plan[0].trainings">
            {{train.name}}
        </ul>
        </div>
    </div>
    <div class="row text-center" v-show="pageIndex < pageLast">
        <a class="button" @click="loadMore()">{{ $t("load") }}</a>
    </div>
</template>

<script>
    export default {
        
        props: { 
            id : {},
            orderBy : {
                required : true
            },
            searchText : {}
        },

        created : function () {
            this.getPrimaryPlans();
        },

        ready : function () {
            this.$on('_planadded', this.PlanAdded);
        },

        data () {
            return {
                plans : [],
                pageIndex : 1,
                pageLast : 0,
            }
        },

        methods : {
            PlanAdded : function(primary) {
                this.plans.push(primary);
            },

            loadMore : function () {
                this.pageIndex ++;
                this.getPrimaryPlans();
            },

            getPrimaryPlans : function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?type=primary&' + 
                    this.orderBy + '&page=' + this.pageIndex).then(res => {
                    this.plans = this.plans.concat(res.data.result.data);
                    this.pageLast = res.data.result.last_page;
                }).catch(err => {

                });
            },
        },

        watch: {
            searchText : function (val, oldVal) {
                this.plans = [];
                this.getPrimaryPlans();
            },

            orderBy : function (val, oldVal) {
                this.plans = [];
                this.pageIndex = 1;
                this.getPrimaryPlans();
            },
        },

        locales: {
            en: { 
                load : 'Load More ...',
            },
            mn : {
                load : 'Цааш нь ...',
            },
        }
    }
</script>
