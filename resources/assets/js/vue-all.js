Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('_token').getAttribute('value');

var math = {
		    '+': function(a, b) { return a + b },
		    '-': function(a, b) { return a - b },
		    '>': function(a, b) { return a > b },
		    '<': function(a, b) { return a < b },
		};

var toTitleCase = function(string)
{
	var strings = string.replace('_', ' ').split(' ');
	for(var i = 0; i < strings.length; i++)
	{
		strings[i] = strings[i].charAt(0).toUpperCase() + strings[i].slice(1);
	}
	return strings.join(' ');
}

Vue.prototype.toTitleCase = toTitleCase;

Vue.mixin({
	methods: {
		generateUrlVars: function(includes) {
			var include = $.param(includes);
			return include;
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





