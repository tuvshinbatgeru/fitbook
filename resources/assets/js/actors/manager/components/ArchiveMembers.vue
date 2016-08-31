<template>
    <h3>Archive Members</h3>

    <div class="row">
        Percentage of lolloloasdsadfsdfl
    </div>
</template>

<script>
    export default {
        
        props: { 
            id : {},
            type : {},
        },

        created : function () {

        },

        ready : function () {
            this.$on('_MemberTypeChanged', (memberType) => {
                this.type = memberType;
            });
        },

        methods : {

        },
    }
</script>
