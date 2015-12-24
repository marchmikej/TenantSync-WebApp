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
			'../../../public/css/app.css',
			'../fullcalendar/fullcalendar.min.css'
		])
		.scripts([
			// '../bower/bootstrap/dist/js/bootstrap.min.js',
			'../bower/moment/min/moment.min.js',
			'../bower/moment-timezone/builds/moment-timezone.min.js',
			'../bower/datetimepicker/build/js/datetimepicker.min.js',
			'../fullcalendar/fullcalendar.min.js'
		],
			'public/js/plugins.js'
		)
		.scripts([
				'../bower/jquery/dist/jquery.min.js',
				'../theme/dist/toolkit.min.js',
				'../../../node_modules/vue/dist/vue.js', 
				'../../../node_modules/vue-resource/dist/vue-resource.min.js',
				'../../../node_modules/numeral/numeral.js',
				'app.js'
			], 
			'public/js/vendor.js'
		)
});

