var elixir = require('laravel-elixir');

// elixir.config.js.browserify.watchify.enabled = true;
// elixir.config.js.browserify.watchify.options = {cache: {}, packageCache: {}};

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
		//.scripts([
		// 	'../../../node-modules/jquery/dist/jquery.min.js',
		// 	'../theme/dist/toolkit.min.js',
		// 	'../../../node_modules/vue/dist/vue.js', 
		// 	'../../../node_modules/vue-resource/dist/vue-resource.min.js'
		// ], 
		// 	'public/js/core.js'
		// )
		// .scripts([
		// 	// '../bower/moment/min/moment.min.js',
		// 	// '../bower/moment-timezone/builds/moment-timezone.min.js',
		// 	// '../bower/datetimepicker/build/js/datetimepicker.min.js',
		// 	'../../../node_modules/numeral/numeral.js',
		// 	//'../fullcalendar/fullcalendar.min.js',
		// 	'../../../node_modules/underscore/underscore.js'
		// ],
		// 	'public/js/plugins.js'
		// )
		.browserify([
			'core.js',
			'plugins.js'
		], 
		'public/js/core.js', null)
		.browserify([
			'vue-all.js',			
			'tenant-sync/tables/transactions-table.js',
			'tenant-sync/tables/property-manager-table.js',
			'tenant-sync/tables/most-expensive-property.js',
			'tenant-sync/tables/devices-table.js',
			'tenant-sync/tables/portfolio-table.js'
		], 
		'public/js/app.js', null)
});

