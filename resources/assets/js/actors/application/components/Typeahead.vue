<template>
  <div class="site-search-input">
    <i class="fa fa-spinner fa-spin" v-if="loading"></i>
    <template v-else>
      <i class="fa fa-search" style="color:#3f4652" v-show="isEmpty"></i>
      <i class="fa fa-times" style="color:#3f4652" v-show="isDirty" @click="reset"></i>
    </template>

    <input type="text"
           class="Typeahead__input"
           :placeholder="placeholder"
           autocomplete="off"
           v-model="query"
           @keydown.down="down"
           @keydown.up="up"
           @blur="blur"
           @focus="show = true"
           @keyUp="search | debounce debounce"
           @keydown.enter="hit"
           @keydown.esc="reset"/>

    <div class="Typeahead__result" v-show="show">
      <slot name="header">
        
      </slot>
      <slot name="result">
        <ul>
          <li v-for="item in items" :class="activeClass($index)" @mousedown="hit" @mousemove="setActive($index)">
              <component :is="matchContext(item)" 
                         :item="item" 
                         >
                
              </component>
          </li>
        </ul>
      </slot>
      <slot name="footer">
          
      </slot>
    </div>

  </div>
</template>

<script>
import Controlable from '../mixins/Controlable'
import Loadable from '../mixins/Loadable'
import GraphUserResult from '../context/GraphUserResult.vue'
import GraphPlanResult from '../context/GraphPlanResult.vue'
import GraphClubResult from '../context/GraphClubResult.vue'

export default {
  mixins: [
      Loadable, Controlable
  ],

  props : {
      limit : {
          default : 5
      },
      minChars : {
          default : 3
      },
      debounce : {
          default : 500
      },
      placeholder : {
          default : 'search ...'
      }
  },
  
  data () {
    return {
      query : '',
      show : false,
    }
  },

  filters : {
      contextFilter : function (type) {
          switch (type) {
              case "App\\User" : 
                return 'graph-user-result';
              case "App\\Plan" : 
                return 'graph-plan-result';
              case "App\\Club" :
                return 'graph-club-result';
          }
          return '';
      }
  },

  computed: {
    isEmpty () {
      return !this.query
    },

    isDirty () {
      return !!this.query
    }
  },

  methods: {
    blur () {
        this.show = false;
    },

    reset () {
      this.items = []
      this.query = ''
      this.loading = false
    },

    matchContext : function (item) {
      switch (item.searchable_type) {
          case "App\\User" : 
            return 'graph-user-result';
          case "App\\Plan" : 
            return 'graph-plan-result';
          case "App\\Club" :
            return 'graph-club-result';
      }
      return '';
    },

    search : function () {
      if (!this.query) {
        return this.reset()
      }

      if (this.minChars && this.query.length < this.minChars) {
        return
      }
      
      this.$emit('search-change', this.query);
    },

    onHit (item) {
      this.show = false;
      switch(item.searchable_type) {
          case "App\\User" :
          window.location.href = this.$env.get('APP_URI') + 'users/' + item.searchable.username;
          break;
          case "App\\Plan" :
          window.location.href = this.$env.get('APP_URI') + 'plan/' + item.searchable_id;
          break;
          case "App\\Club" : 
          window.location.href = this.$env.get('APP_URI') + item.searchable.club_id;
          break;
          default :
      }
      
    }
  },

  components : {
      GraphUserResult, GraphPlanResult, GraphClubResult
  }
}
</script>



<style scoped>

.fa-times {
  cursor: pointer;
}

i {
  font-size: 17px;
  float: right;
  position: absolute;
  top: 25%;
  left: 15px;
  opacity: 0.4;
  font-size: 17;
}

.Typeahead__result {
  font-size: 12px;
  position: absolute;
  padding: 0;
  margin-top: 8px;
  min-width: 100%;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0,0,0, 0.25);
  border-radius: 4px;
}

ul {
  position: relative;
  list-style: none;
  z-index: 1000;
}

li {
  padding: 10px 16px;
  cursor: pointer;
}

li:first-child {
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
}

li:last-child {
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 4px;
  border-bottom: 0;
}

.active {
  background-color: #f6f9fa;
}

.active span {
 
}

.name {
  font-weight: 700;
  font-size: 12px;
}

.screen-name {
  font-style: italic;
}
</style>
