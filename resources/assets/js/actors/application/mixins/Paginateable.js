export default {
  props : {
    loading : {
      type : Boolean,
      default : false
    }
  },

  data () {
    return {
        pageIndex : 1,
        pageLast : 0,
    }
  },

  methods: {
      resetPage : function () {
          this.pageIndex = 1
      }
  }
}
