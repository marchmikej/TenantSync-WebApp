var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix		
		.less(['app.less'])
		.styles([
			'fullcalendar.min.css'
		], 'public/css/fullcalendar.min.css', 'resources/assets/fullcalendar')
		.styles([
			'app.css',
		], 'public/css', 'public/css')
		.scripts([
			'../bower/jquery/dist/jquery.min.js',
			'../theme/dist/toolkit.min.js',
			'../../../node_modules/vue/dist/vue.js', 
			'../../../node_modules/vue-resource/dist/vue-resource.min.js'
		], 
			'public/js/app.js'
		)
		.scripts([
			'../bower/moment/min/moment.min.js',
			'../bower/moment-timezone/builds/moment-timezone.min.js',
			'../bower/datetimepicker/build/js/datetimepicker.min.js',
			'../../../node_modules/numeral/numeral.js',
			'../fullcalendar/fullcalendar.min.js'
		],
			'public/js/plugins.js'
		)
		.browserify([
			'vue-all.js',

		],

		)
});

