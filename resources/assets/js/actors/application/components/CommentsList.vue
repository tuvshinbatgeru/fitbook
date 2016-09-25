<template>
    <div>
        <ul>
            <li v-for="comment in comments">
                {{comment.created_at | moment "from"}}
                {{{comment.message}}}

                <a :v-show="loggedUser">thumbs up</a>
                <a :v-show="loggedUser">reply</a>
            </li> 
        </ul>

        <a v-show="pageIndex < pageLast" @click="loadMore()">Load More</a>
    </div>
</template>

<script>

    export default {
        props : {
            id : {},
            type : {},
            show : {
                default : false
            },
            loggedUser : {
                default : null
            }
        },

        data() {
            return {
                comments : [],
                pageIndex : 1,
                pageLast : 0,
            }
        },

        created : function () {
            this.getComments();
        },

        methods : {
            getComments : function () {
                this.$http.get(this.$env.get('APP_URI') + 'plan/'+ this.id +'/comments?page=' + this.pageIndex).then(res => {
                    this.comments = this.comments.concat(res.data.result.data);
                    this.pageLast = res.data.result.last_page;
                }).catch(err => {
                });
            },

            loadMore : function () {
                this.pageIndex ++;
                this.getComments();
            }
        }
    }
</script>

<style lang="scss">
</style>