(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('_token').getAttribute('value');

var math = {
	'+': function _(a, b) {
		return a + b;
	},
	'-': function _(a, b) {
		return a - b;
	},
	'>': function _(a, b) {
		return a > b;
	},
	'<': function _(a, b) {
		return a < b;
	}
};

Vue.numeral = window.numeral;

var toTitleCase = function toTitleCase(string) {
	var strings = string.replace('_', ' ').split(' ');
	for (var i = 0; i < strings.length; i++) {
		strings[i] = strings[i].charAt(0).toUpperCase() + strings[i].slice(1);
	}
	return strings.join(' ');
};

Vue.prototype.toTitleCase = toTitleCase;

},{}],2:[function(require,module,exports){
'use strict';

Vue.mixin({

	data: function data() {
		return {
			sortKey: '',

			reverse: 1
		};
	},

	methods: {
		sortBy: function sortBy(index) {
			if (!this.columns[index].isSortable) {
				return false;
			}

			var sortKey = this.columns[index].name;
			this.reverse = this.sortKey == sortKey ? this.reverse * -1 : 1;
			this.sortKey = sortKey;
		},

		sortKeyClasses: function sortKeyClasses(index) {
			if (!this.columns[index].isSortable) {
				return false;
			}

			var sortKey = this.columns[index].name;
			var classes = ['icon'];

			if (sortKey == this.sortKey) {
				classes.push('text-warning');
				if (this.reverse > 0) {
					classes.push('icon-chevron-up');
					return classes;
				}
				classes.push('icon-chevron-down');
				return classes;
			}
			classes.push('icon-chevron-up', 'text-muted');
			return classes;
		}
	}
});

},{}]},{},[1,2]);

//# sourceMappingURL=bundle.js.map
