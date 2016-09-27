Vue.directive('foundation-dropdown-menu', {
  bind () {
    this.dropdown = new Foundation.DropdownMenu($(this.el))
  }
})