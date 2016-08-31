<template>
  <div class="row">
    <div class="small-10 columns">
      <input type="text" name="search" placeholder="search ...">
    </div>
    <div class="small-2 columns">
      <div class="small-2 columns">
            <a @click="showAddTraining = true" class="button success">
                <i class="fa fa-pencil-square-o">
                         
                </i>
            </a>
      </div>
    </div>
  </div>

  <custom-modal 
        :id = "id"
        type = "Club"
        title = "Хичээл нэмэх" 
        title_en = "Add Training"
        usage = "_add-training" 
        :show.sync = "showAddTraining"
        save-callback = "saveTraining"
        validateable = 'Y'
        context = "AddTraining"
        >
  </custom-modal>

  <ft-training :item = "train" v-for = "train in training">
      
  </ft-training>

</template>

<script>

  import FtTraining from '.././components/FtTraining.vue';

  export default {
    props: { 
      id : {},
    },

    data() {
      return {
          training : [],
          showAddTraining : false
      }
    },

    created: function () {
        this.getTrainings();
    },

    events : {
        'saveTraining' : function($response) {
          this.saveTraining($response);
        },
    },

    methods : {
        getTrainings : function () {
            this.$http.get(this.$env.get('APP_URI') + 'api/club/' + this.id + '/training').then(res => {
              debugger;
                this.training = res.data.result;
            }).catch(err => {

            });
        },

        saveTraining : function($response) {
            this.$http.post(this.$env.get('APP_URI') + 'api/club/' + this.id + '/training?data=' + $response.data).then(res => {
            }).catch(err => {

            });
            this.showAddTraining = false;
            this.$root.$refs.toast.showMessage('Successfully add new training.');
        }
    },

    components : {
        FtTraining
    },

    locales: {
        en: { 
            plan : 'Plan',
            loyalty : 'Loyalty',
        },
        mn : {
            plan : 'Хөтөлбөр',
            loyalty : 'Урамшуулал',
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