export default {
  props : {
    loading : {
      type : Boolean,
      default : false
    }
  },

  methods: {
      setLoading : function (state) {
          this.loading = state;
      }
  }
}
