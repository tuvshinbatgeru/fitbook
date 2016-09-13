<template>
    <div class="row small-up-3 medium-up-4 large-up-4">
        <div v-for="current in subscriptions" class="columns">
            <div class="row">
                <div class="small-3 column">
                    <img :src="current.pinned_photos[0].url" />
                </div>
                <div class="small-9 column">
                    <h3>{{current.name}}</h3>
                    <p>{{current.description}}</p>

                    <label>{{current.pivot.begin_date}}</label>-
                    <label>{{current.pivot.end_date}}</label>
                </div>
            </div>            
        </div>
    </div>
</template>

<script>
    export default {

        props: { 
            id : {},
        },

        data () {
            return {
                subscriptions : [],
            }
        },
        
        created : function () {
            this.getSubscriptions();
        },

        ready : function () {

        },

        methods : {
            getSubscriptions : function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/user/' + this.id + '/subscriptions').then(res => {
                    this.subscriptions = res.data.result;
                    debugger;
                }).catch(err => {

                });
            }
        },
    }
</script>
