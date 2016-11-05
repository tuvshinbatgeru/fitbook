<template>
  <div class="row small-up-3 medium-up-4 large-up-5">
    <div class="column" v-for="service in services">
        <img style="height:200px; width:200px;" :src="service.photo.url"/>
        <h3>
          {{service.name}}
        </h3>
        <a @click="changePhoto(service)" class="button fa fa-plus"></a>
    </div>
  </div>

  <input type="Number" />

  <custom-modal 
      title ="Photo chooser" 
      usage = "_photo-chooser" 
      :show.sync = "showFileManager"
      save-callback = "chooseServicePhoto">
      <div slot="body">
        <component 
          v-ref:filemanager 
          is="file-manager"
        ></component>
      </div>
  </custom-modal>

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
  
  import FileManager from '../../../context/FileManager.vue'

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
        showFileManager : false,
        selectedService: null
      }
    },

    created: function () {
        this.init()
    },

    ready : function () {

    },

    events : {
        'chooseServicePhoto' : function ($response) {
            if($response.data.length > 0) {
                this.setServicePhoto($response.data[0])
            }
        }
    },

    methods : {
        init : function () {
            this.getServices()
            this.getGenres()
        },

        changePhoto : function (service) {
            this.selectedService = service
            this.showFileManager = true
        },

        setServicePhoto : function (photo) {
            this.$http.post(this.$env.get('APP_URI') + 'api/club/' + this.id + '/service/photo?service_id=' + this.selectedService.id + '&photo_id=' + photo.id).then(res => {
                this.selectedService.photo = photo
                this.showFileManager = false    
                this.$root.$refs.toast.showMessage(res.data.message)
            }).catch(err => {
                this.showFileManager = false    
            });
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
                this.$root.$refs.loader.show = false
            }).catch(err => {
                this.$root.$refs.loader.show = false
            });
        },

        updateGenres : function (value) {
            this.genreType = value
        },

        updateServices : function (value) {
            this.serviceType = value
        },

        filterByGenreType : function (genre) {
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
    }, 

    components : {
        FileManager
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

.Service__Count {
    padding : 5px;
    border-radius: 5px;
    background-color : #ff5c2d;
    color: #3f4652;
}
</style>