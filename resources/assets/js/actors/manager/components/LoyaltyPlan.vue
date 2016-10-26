<template>
    <div v-show="plans.length == 0" class="row text-center">
            <span style="color:#3f4652">{{$t('noresult')}}</span>
    </div>
    <div v-else class="row small-up-1 large-up-2" style="font-size:12px;">
        <div class="columns" v-for="current in plans">
        <div class="row text-right">
            <span style="font-size: 25px; color: #3f4652;" @click="editDropClicked(current)" class="fa edit__dropdown fa-ellipsis-h" :data-toggle="'plan-edit-' + current.id">
                <div class="dropdown-pane bottom" v-bind:id="'plan-edit-' + current.id" data-dropdown data-close-on-click="true">
                    <a class="fa" @click="editPlan(current)">Edit</a>    
                    <a class="fa" @click="deletePlan(current)">Delete</a>
                    <a>
                        <span class="fa fa-history"></span> 
                        <a @click="setShowHistory(current)" :data-toggle="'plan-history-' + current.id">{{current.histories_count}}</a>

                         <div class="dropdown-pane bottom" v-bind:id="'plan-history-' + current.id" data-dropdown data-close-on-click="true">
                             <div v-if="current.showPlanHistory">
                                 <adjustment-histories :id="current.id" type='plan-adjustment'>
                                 
                                 </adjustment-histories>
                             </div>
                         </div>
                    </a>
                </div>
            </span>
            
            
        </div>

        <h3><a>{{current.name}}</a></h3>
        <custom-selection-list 
                :limit="2" 
                :total="current.teachers_count"
                :items="current.first_two_teachers"
                :item-text="itemText"
                @clicked="allTeachers(current)"
                :limit-before="teacherLimitBefore"
                :limit-after="teacherLimitAfter">
        </custom-selection-list>

        <span style="background-color:#3f4652; color:#fff; padding:5px; border-radius:5px;">{{current.frequency_type | freqFilter}}</span>
        <span style="background-color:#3f4652; color:#fff; padding:5px; border-radius:5px;">{{current.length}}</span>

        <div class="row text-center">
            {{current.created_at | moment "from"}}
            <span class="fa fa-heart" style="color: red;"></span>
            <strong>{{current.hearts_actions_count}}</strong>

            <span class="fa fa-comments-o" style="color: #3f4652;"></span>
            <strong>{{current.comments_count}}</strong>

            <span class="fa fa-eye"></span>
            <strong>{{current.visitors_count}}</strong>

            <span class="fa fa-users"></span>
            <strong>{{current.subscriptions_count}}</strong>
        </div>
        
        <p>{{{current.description}}}</p>

        <div style="width:300px; height:100px; overflow: hidden;">
            <img v-lazy="current.pinned_photos[0].url"
                 style="width: 100%;
    position: relative;
    max-height: none;" 
                 :style = "{ 
                        top: -1 * parseInt((current.pinned_photos[0].pivot.top_percentage * 300 * current.pinned_photos[0].ratio) / 100) + 'px'
                 }" />    
        </div>

        <label>{{current.planable.before_price}}</label>
        off to 
        <label>{{current.price}}</label>

        <ul v-for="teacher in current.teachers">
            {{teacher.username}}
        </ul>
        <ul v-for="service in current.services">
            {{service.name}}
        </ul>
        </div>
    </div>
    <div class="row text-center" v-show="pageIndex < pageLast">
        <a class="button" @click="loadMore()">{{ $t("load") }}</a>
    </div>
</template>

<script>
    import Planable from '../mixins/Planable'

    export default {
        
        mixins : [Planable],
        
        methods : {
            getPlans : function () {
                this.loadStart();

                this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/plan?type=loyalty&' + 
                    this.orderBy + '&page=' + this.pageIndex + this.filterParam()).then(res => {
                    this.plans = this.plans.concat(res.data.result.data);
                    this.pageLast = res.data.result.last_page;

                    this.loadStop();
                }).catch(err => {
                    this.loadStop();
                });
            },
        },
    }

</script>