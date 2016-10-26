<template>
  <div class="row small-up-3 medium-up-4 large-up-5">
    <div class="column" v-for="service in services">
        <img style="height:32px; width:32px;" src="/images/pin.png"/>
        <h3>
          {{service.name}}
        </h3>
        <a class="button fa fa-plus"></a>
    </div>
  </div>

  <multiselect 
      :options="['all', 'incomplete', 'complete']" 
      :selected="genreType" 
      :multiple="false"
      :clear-on-select="false" 
      :close-on-select="true" 
      :searchable="false"
      select-label='сонгох'
      selected-label='сонгосон' 
      deselect-label='устгах'
      @update="updateGenres"
      :placeholder="$t('genre')">
        <span slot="noResult">Илэрц алга ...</span>
  </multiselect>

  <div class="row small-up-5">
    <div v-for="genre in filteredGenres" class="column">
      <span class="Genre__name">{{genre.name}}</span>
      <span v-show="genre.pivot.amount == -1" class="Genre__Plus fa fa-plus">
      </span>
      <span v-else class="Genre__Amount">
        {{genre.pivot.amount}}
      </span>
    </div>
  </div>
</template>

<script>
  
  export default {
    props: { 
      id : {},
    },

    data() {
      return {
        services : [],
        genres : [],
        serviceType : 'all',
        genreType : 'all',
      }
    },

    created: function () {
        this.init()
    },

    ready : function () {

    },

    methods : {
        init : function () {
            this.getServices()
            this.getGenres()
        },

        getGenres : function () {
            this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/capability').then(res => {
                this.genres = res.data.result
            }).catch(err => {

            });
        },

        getServices: function () {
            this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/service').then(res => {
                this.services = res.data.result
            }).catch(err => {

            });
        },

        updateGenres : function (value) {
            this.genreType = value
        },

        updateServices : function (value) {
            this.serviceType = value
        },

        filterByGenreType : function (genre) {
            debugger
            if(this.genreType == 'all') return true
            if(this.genreType == 'complete' && genre.pivot.amount != -1) return true  
            if(this.genreType == 'incomplete' && genre.pivot.amount == -1) return true
            return false
        }
    },

    computed : {
        filteredGenres : function () {
            return _.filter(this.genres, this.filterByGenreType)
        }
    },

    locales: {
        en: { 
            plan : 'Plan',
            loyalty : 'Loyalty',
            genre : 'Genre',
        },
        mn : {
            plan : 'Хөтөлбөр',
            loyalty : 'Урамшуулал',
            genre : 'Төрөл',
        },
    }
  }
</script>
  
<style lang="scss">

.Genre__name {
    font-size: 12px;
    padding : 5px;
    background-color: #3f4652;
    color : #fff; 
    border-top-left-radius: 3px;
    border-bottom-left-radius : 3px;
    float: left;
}

.Genre__Amount {
    padding : 5px;
    font-size: 12px;
    background-color : #34ad58 !important;
    color : #3f4652 !important;
    border-top-right-radius: 3px;
    border-bottom-right-radius : 3px;
    float: left;
}

.Genre__Plus {
    padding : 5px;
    font-size: 12px;
    background-color : #ff5c2d !important;
    color : #fff !important;
    border-top-right-radius: 3px;
    border-bottom-right-radius : 3px;
    float: left;
}
</style>