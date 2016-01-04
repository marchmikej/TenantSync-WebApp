Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('_token').getAttribute('value');

var math = {
		    '+': function(a, b) { return a + b },
		    '-': function(a, b) { return a - b },
		    '>': function(a, b) { return a > b },
		    '<': function(a, b) { return a < b },
		};

Vue.numeral = window.numeral;

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