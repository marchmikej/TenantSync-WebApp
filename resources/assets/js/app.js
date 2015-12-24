Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('_token').getAttribute('value');

var math = {
		    '+': function(a, b) { return a + b },
		    '-': function(a, b) { return a - b },
		    '>': function(a, b) { return a > b },
		    '<': function(a, b) { return a < b },
		};

Vue.numeral = window.numeral;