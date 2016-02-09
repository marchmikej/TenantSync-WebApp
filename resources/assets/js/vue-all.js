Vue.config.debug = true;

Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('_token').getAttribute('value');

Vue.prototype.numeral = window.numeral;
Vue.prototype.moment = window.moment;
Vue.prototype._ = window._;

Vue.mixin({
	methods: {
		generateUrlVars: function(includes) {
			var include = $.param(includes);
			return include;
		},

		toTitleCase: function(string)
		{
			var strings = string.replace('_', ' ').split(' ');
			for(var i = 0; i < strings.length; i++)
			{
				strings[i] = strings[i].charAt(0).toUpperCase() + strings[i].slice(1);
			}
			return strings.join(' ');
		},

		confirm: function(action, object, id) {
			swal({   
				title: 'Just Checking',   
				text: 'Are you sure you want to '+ action +' this '+ object.toLowerCase() +'?',   
				type: 'warning',   
				showCancelButton: true,   
				confirmButtonColor: '#3085d6',   
				cancelButtonColor: '#d33',   
				confirmButtonText: 'Yes',   
				closeOnConfirm: true }, 
				function(confirmed) { 
					return confirmed ? this[action + object](id) : false;
				}.bind(this));
		},
	}
});

Vue.filter('search', function (list, string) {
	if(! string) {
		return list;
	}

  	return _.filter(list, function(object) {
  		return _.find(object, function(property) {
  			if(typeof property === 'string') {
  				return property.toLowerCase().includes(string.trim().toLowerCase());
	  		}
	  		return false;
	  	}.bind(string));
  	}.bind(string));
});

Vue.filter('whereNotIn', function (list, sourceList, property) {
	if(! sourceList || ! property) {
		return list;
	}

  	return _.filter(list, function(object) {
  		return ! _.size(_.where(sourceList, {'id': object[property]}));
  	});
});

/* TenantSync Initializing */
window.TS = {

};





