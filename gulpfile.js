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
		.less([
			'app.less', 
			'../sweetalert2/dist/sweetalert2.css', 
			'../select2/dist/css/select2.css', 
			'../select2/dist/css/select2-bootstrap.css', 
		])
		.styles([
			'fullcalendar.min.css'
		], 'public/css/fullcalendar.min.css', 'resources/assets/fullcalendar')
		.styles([
			'app.css',
		], 'public/css', 'public/css')
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

