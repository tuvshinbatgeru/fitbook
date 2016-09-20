<template>
    <div class="row" v-for="activity in activities">
        <h3>{{activity.short_name}}</h3>
        <label>{{activity.pivot.duration}} min</label>
    </div>
</template>

<script>
    export default {
        
        props: { 
            id : {},
        },

        data () {
            return {
                activities : [],
            }
        },

        created : function () {
            this.getActivity();
        },

        ready : function () {

        },

        methods : {
            getActivity : function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.id + '/activity').then(res => {
                    this.activities = res.data.result;
                }).catch(err => {
                });
            }
        },
    }
</script>
