window.TSTable = Vue.component('ts-table', {

	props: [{
			name: 'search',
			default: null
		}],

    data: function() {
    	return {
    		sortKey: null,

			reverse: -1,

			currentPage: 1,

			lastPage: 1,

			perPage: 15,

			range: {
				from: moment().subtract(1, 'month').format(dateString),
				to: moment().format(dateString)
			},
		};
	},

	computed: {
		filteredList: function () {
		    var filter = Vue.filter('filterBy');
		    return filter(this[this.listName], this.search);
		},

		lastPage: function() {
			return Math.ceil(Number(_.size(this.filteredList)) / Number(this.perPage));
		},
	},

	events: {
		'table-sorted': function(sortKey) {
			//this.reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;
			this.reverse = this.reverse * -1;

			this.sortKey = sortKey;
		},

		'modal-hidden': function() {
			if(this.hasOwnProperty('modalHidden')) {
				this.modalHidden();
			}
		},
	},

	methods: {

		previousPage: function() {
			if(this.currentPage > 1) {
				this.currentPage --;
			}
		},

		nextPage: function() {
			if(this.currentPage < this.lastPage) {
				this.currentPage ++;
			}
		},

		isLastPage: function() {
			return this.currentPage == this.lastPage;
		},

		inCurrentPage: function(index) {
			return ((this.currentPage -1) * this.perPage) <= index && index < (this.currentPage * this.perPage);
		},
	},
});

