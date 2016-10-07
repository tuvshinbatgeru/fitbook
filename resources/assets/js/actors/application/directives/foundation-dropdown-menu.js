Vue.directive('foundation-dropdown-menu', {
  bind () {
    new Foundation.DropdownMenu($(this.$el))
  },

  unbind() {

  }
})