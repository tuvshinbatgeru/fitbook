Vue.directive('foundation-dropdown', {
  bind () {
  	debugger;
    new Foundation.Dropdown($(this.el))
  },
  unbind() {

  }
})