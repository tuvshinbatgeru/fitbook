<template>
  <div class="row">
    <div class="small-10 columns">
      <input type="text" name="search" placeholder="search ...">
    </div>
    <div class="small-2 columns">
      <div class="small-2 columns">
            <a @click="showAddService = true" class="button success">
                <i class="fa fa-pencil-square-o">
                         
                </i>
            </a>
      </div>
    </div>
  </div>

  <custom-modal 
        :id = "id"
        type = "Club"
        title = "Үйлчилгээ сонгох" 
        title_en = "Add Service"
        usage = "_add-service" 
        :show.sync = "showAddService"
        save-callback = "chooseService"
        context = "services">
        <div slot="body">
          <component v-ref:context 
                     :id="id" 
                     :selected = "services"
                     is="services">
          </component>
        </div>
  </custom-modal>

  <div class="row small-up-3 medium-up-4 large-up-5">
    <div class="column" v-for="service in services">
        <img src="/images/pin.png"/>
        <h3>
          {{service.name}}
        </h3>
        <a class="button fa fa-plus"></a>
    </div>
  </div>
</template>

<script>
  
  import services from '../../../context/services.vue';

  export default {
    props: { 
      id : {},
    },

    data() {
      return {
        services : [],
        showAddService : false
      }
    },

    created: function () {
        this.getServices();
    },

    events : {
        'chooseService' : function($response) {
          this.chooseService($response);
        },
    },

    methods : {
        getServices: function () {
          this.$http.get(this.$env.get('APP_URI') + '/api/club/' + this.id + '/service').then(res => {
              this.services = res.data.result;
          }).catch(err => {

          });
        },

        chooseService : function($response) {
            this.$http.post(this.$env.get('APP_URI') + 'api/club/' + this.id + '/service/edit?data=' + $response.data).then(res => 
            {
                this.services = res.data.result;
                this.showAddService = false;
                this.$root.$refs.toast.showMessage('Successfully choose services');
            }).catch(err => {
                this.$root.$refs.toast.showMessage('Error');
            });
        }
    },

    components : {
        services
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
</style>