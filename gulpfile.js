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
var paths = {
    'foundation' : './bower_components/foundation-sites/scss',
    'motion' : './bower_components/motion-ui/src',
    'materialize' : './bower_components/materialize'
}

elixir(function(mix) {
	mix.sass('app.scss', 'public/css/app.css', {
		includePaths: 
		[
			paths.foundation,
			paths.motion,
			paths.materialize
		]
	});

	mix.version("css/app.css");

	mix.sass(['style.scss'],'public/css/style.css');
	mix.sass(['widget/hw-default.scss'],'public/css/widget/hw-default.css');
	mix.sass(['widget/cw-default.scss'],'public/css/widget/cw-default.css');
	mix.browserify('app.js');
});
