var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

	mix.sass(['app.scss'], 'public/css/app.css', {
		includePaths : 
		[
			'./bower_components/foundation-sites/scss',
			'./bower_components/motion-ui/src',
			'./bower_components/materialize',
		]
	});

	
	//mix.sass(['style.scss'],'public/css/style.css');
	mix.browserify('app.js');	
	mix.version(['css/app.css', 'js/app.js']);
	/*mix.sass(['widget/hw-default.scss'],'public/css/widget/hw-default.css');
	mix.sass(['widget/cw-default.scss'],'public/css/widget/cw-default.css');*/
	
});
