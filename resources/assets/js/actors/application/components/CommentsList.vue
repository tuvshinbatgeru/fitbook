<template>
    <div>
        <ul>
            <li v-for="comment in comments">
                {{comment.created_at | moment "from"}}
                {{{comment.message}}}

                <a v-show="loggedUser">Thumbs up</a>
                <a @click="setCommentReply(comment)" 
                   v-show="loggedUser">Reply</a>

                <ul v-if="loggedUser.id == comment.user_id" class="dropdown menu" data-dropdown-menu v-foundation-dropdown-menu>
                    <li class="is-dropdown-submenu-parent">
                        <a href="#"></a>
                        <ul class="menu">
                          <li><a>Edit</a></li>
                          <li><a>Delete</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="row" v-if="comment.reply">
                    <div class="small-3 column">
                        <img style="height:32px; width:32px;" 
                        :src="loggedUser.avatar_url"/>    
                    </div>
                    <div class="small-9 column text-left">
                        <custom-comment 
                            :parent-id="comment.id" 
                            parent-type='Comment'
                            :toolbar="false"></custom-comment>
                    </div>
                </div>
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

        ready : function () {
            this.loggedUser = JSON.parse(this.loggedUser);
        },

        methods : {
            setCommentReply : function (comment) {
                Vue.set(comment, 'reply', true);
            },

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