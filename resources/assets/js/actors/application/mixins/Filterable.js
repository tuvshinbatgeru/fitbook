export default {
  props : {
    filters : {}
  },

  methods: {
      findFilter : function (name) {
          var filter = _.find(this.filters, function (obj) {
              return obj.name == name
          })

          return filter
      }, 

      getFilterValue : function (name, defaultValue) {
          var filter = this.findFilter(name)        
          if(filter) 
            return filter.value

          return defaultValue
      }
  }
}
