import AdjustmentHistories from '../../application/components/AdjustmentHistories.vue'

export default {
      props : {
        id : {
          required : true
        },
      },

      data () {
        return {
            plans : [],
            pageIndex : 1,
            pageLast : 0,
            planFilters : null,
        }
      },

      filters : {
          freqFilter : function (freq) {
              switch(freq) {
                  case 1 :
                      return "dayly";
                  case 2 :
                      return "weakly";
                  case 3 :
                      return "monthly";
                  case 4 : 
                      return "yearly";
                  default : 
                      return "dayly";
              }
          }
      },

      created : function () {
          this.getPlans();
      },

      ready : function () {
          this.$on('_planadded', this.PlanAdded);
          this.$on('_filtered', this.planFiltered);
      },

      methods: {
          editDropClicked : function (plan) {
              new Foundation.Dropdown($('#plan-edit-' + plan.id));
          },

          setShowHistory : function (plan) {
              Vue.set(plan, 'showPlanHistory', true);
              new Foundation.Dropdown($('#plan-history-' + plan.id));
          },

          editPlan : function (plan) {
              this.$dispatch('editPlan', plan);
          },

          deletePlan : function(plan) {
              this.plans.$remove(plan);
          },

          PlanAdded : function(plan) {
              this.plans.push(plan);
          },

          loadMore : function () {
              this.pageIndex ++;
              this.getPlans();
          },

          planFiltered : function (filters) {
              this.planFilters = filters;
              this.getPlans();
          },

          resetPage : function () {
              this.pageIndex = 1;
              this.plans = [];
          },

          filterParam : function () {
              this.resetPage();
              var params = "";
              _.forEach(this.planFilters, function(filter) {
                  params += "&" + filter.name + "=" + filter.order;
              });

              return params;
          },

          allTeachers : function (current) {
              this.$dispatch('allTeachers', current);
          },

          teacherLimitBefore : function() {
              return this.$t('and');
          },

          teacherLimitAfter : function() {
              return this.$t('other');
          },

          itemText : function (item) {
              return '<a href="/users/' + item.username + '">' + item.first_name + ' ' + item.last_name + '</a> ';
          },

          getPlans : function () {
              console.log('implement own plans method :D')
          },
      },

      components : {
          AdjustmentHistories
      },

      locales: {
          en: { 
              load : 'Load More ...',
              and : 'and ',
              other : ' others teachers',
          },
          mn : {
              load : 'Цааш нь ...',
              and : 'ба бусад ',
              other : ' багш нар'
          },
      }
}
