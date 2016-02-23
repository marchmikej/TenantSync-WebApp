window.TSTable = Vue.component('ts-table', {

    data: function() {
    	return {
    		sortKey: null,

			reverse: -1,

			currentPage: 1,

			search: null,

			range: {
				from: moment().subtract(1, 'month').format(dateString),
				to: moment().format(dateString)
			},
		};
	},

	events: {
		'table-sorted': function(sortKey) {
			this.sortKey = sortKey;
			this.reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;
		},
	},

});

