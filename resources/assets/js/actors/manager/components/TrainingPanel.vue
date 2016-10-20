<template>
  <div class="row">
    <div class="small-10 columns">
      
    </div>
    <div class="small-2 columns">
      <div class="small-2 columns">
            <a @click="addTraining()" class="button success">
                <i class="fa fa-pencil-square-o">
                         
                </i>
            </a>
      </div>
    </div>
  </div>

  <custom-modal title = "Teachers" :show.sync="showTeachers">
    <div slot="body">
      <training-teachers :id="currentTraining.id"></training-teachers>
    </div>
  </custom-modal>

  <custom-modal 
        :id = "id"
        v-ref:addtr
        type = "Club"
        :title = "$t(methodType + '_title')" 
        usage = "_add-training" 
        :show.sync = "showAddTraining"
        save-callback = "saveTraining"
        validateable = 'Y'>
        <div slot="body">
          <components v-ref:context :id="id" is="add-training" :training="currentTraining">
              
          </components>
        </div>
  </custom-modal>

  <div class="row small-up-1 medium-up-2">
    <ft-training :item = "train" v-for = "train in training">
        
    </ft-training>
  </div>
  <div class="row text-center" v-show="pageIndex < pageLast">
        <a class="button" @click="loadMore()">{{ $t("load") }}</a>
  </div>

</template>

<script>

  import FtTraining from '.././components/FtTraining.vue';
  import AddTraining from '../../../context/AddTraining.vue';
  import TrainingTeachers from './TrainingTeachers.vue';

  export default {
    props: { 
      id : {},
    },

    data() {
      return {
          training : [],
          currentTraining : null,
          showAddTraining : false,
          showTeachers : false,
          methodType : 'add',
          copyInstance : null,
          pageIndex : 1,
          pageLast : 0,
      }
    },

    created: function () {
        this.getTrainings();
    },

    events : {
        'saveTraining' : function($response) {
          this.saveTraining($response);
        },

        'deleteTraining' : function($response) {
          this.training.$remove($response);
        },

        'editTraining' : function($response) {
            this.copyInstance = $response;
            this.editTraining($response.id);
        },

        'allTeachers' : function($response) {
            this.currentTraining = $response;
            this.showTeachers = true;
        }
    },

    methods : {
        addTraining : function () {
            this.currentTraining = null;
            this.methodType = 'add';
            this.showAddTraining = true;
        },

        editTraining : function(id) {
            this.$http.get(this.$env.get('APP_URI') + 'training/' + id).then(res => {
                this.methodType = 'edit';
                this.currentTraining = res.data.result;
                this.showAddTraining = true;
            }).catch(err => {
            });
        },

        getTrainings : function () {
            this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/training?page=' + this.pageIndex).then(res => {
                this.training = this.training.concat(res.data.result.data);
                this.pageLast = res.data.result.last_page;
            }).catch(err => {

            });
        },

        storeTraining : function ($response) {
            this.$http.post(this.$env.get('APP_URI') + 'training?data=' + $response.data.param).then(res => {
                if(res.data.code == 0) {
                    var curTraining = res.data.result;
                    var pinned_photos = [];

                    pinned_photos.push($response.data.pinned_photo);
                    curTraining.pinned_photos = pinned_photos;
                    curTraining.genres = $response.data.genres;
                    curTraining.teachers_count = $response.data.teachers.length;
                    curTraining.first_two_teachers = $response.data.teachers;
                    curTraining.histories_count = 0;

                    this.training.shift(curTraining);
                    this.showAddTraining = false;
                }

                this.$refs.addtr.loading = false;
                this.$root.$refs.toast.showMessage(res.data.message);

            }).catch(err => {
                this.$refs.addtr.loading = false;
                this.$root.$refs.toast.showMessage('Server side error!.');
            });
        },

        cloneTraining : function (curTraining) {

            this.copyInstance.name = curTraining.name;
            this.copyInstance.description = curTraining.description;
            this.copyInstance.teachers_count = curTraining.teachers_count;
            this.copyInstance.genres = curTraining.genres;
            this.copyInstance.pinned_photos = curTraining.pinned_photos;
            this.showAddTraining = false;

        },

        updateTraining : function ($response) {
            this.$http.put(this.$env.get('APP_URI') + 'training?data=' + $response.data.param).then(res => {
                if(res.data.code == 0) {
                    var curTraining = res.data.result;
                    var pinned_photos = [];
                    
                    pinned_photos.push($response.data.pinned_photo);
                    curTraining.pinned_photos = pinned_photos;
                    curTraining.first_two_teachers = $response.data.teachers;
                    curTraining.teachers_count = $response.data.teachers.length;
                    curTraining.genres = $response.data.genres;
                    
                    this.cloneTraining(curTraining);
                    this.copyInstance.histories_count ++;
                }

                this.$refs.addtr.loading = false;
                this.$root.$refs.toast.showMessage(res.data.message);

            }).catch(err => {
                this.$refs.addtr.loading = false;
                this.$root.$refs.toast.showMessage('Server side error!.');
            });    
        },

        saveTraining : function($response) {
            this.methodType == "add" ? this.storeTraining($response) : this.updateTraining($response);
        },

        loadMore : function () {
            this.pageIndex ++;
            this.getTrainings();
        },
    },

    components : {
        FtTraining, AddTraining, TrainingTeachers
    },

    locales: {
        en: { 
            plan : 'Plan',
            loyalty : 'Loyalty',
            add_title : 'Add Training',
            edit_title : 'Edit Training',
            load : 'Load More ...',
        },
        mn : {
            plan : 'Хөтөлбөр',
            loyalty : 'Урамшуулал',
            add_title : 'Хичээл нэмэх',
            edit_title : 'Хичээл засах',
            load : 'Цааш нь ...',
        },
    }
  }
</script>
  
<style lang="scss">
.picture-list {
  background-color : #5fcf80;
  border-radius: 4px;
}

.add-button {
  height:120px; 
  width:120px; 
  background-color: #fff; 
  border-radius:4px; 
  border:1px solid #53BBB4;
}

.figure {
  margin:0 10px 10px 0;
  height:120px; 
  width:120px; 
  position:relative;

  &:hover {
      .figcaption {
        opacity: 1;
      }
    }
}

.figcaption {
  border-radius: 4px;
  background-color: rgba(58, 52, 42, 0.7);
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    color: #fff;
    padding: 0 25px;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    transition: all 0.25s;
    opacity: 0;
}

//search

.gh-search-submit {
    opacity: 0.75;
    z-index: 9999;
    background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…KCUM1LjE1NCwxMi44NTUsMi44MjQsMTAuNTI3LDIuODI0LDcuNjY2eiIvPg0KPC9zdmc+DQo=");
}

.gh-search-reset.show {
    cursor: pointer;
    z-index: 9999;
    opacity: 1;
    -webkit-transform: translateX(0px);
    -ms-transform: translateX(0px);
    transform: translateX(0px);
    -webkit-transition-delay: .2s;
    transition-delay: .2s;
}
</style>