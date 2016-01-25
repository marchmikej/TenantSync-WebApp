module.exports = {

	props: ['columns', 'sortKey', 'reverse'],

	template: '<div class="table-heading row">\
				<div v-for="column in columns" @click="sortBy(column)" :class="[column.width, column.isSortable ? \'sortable\' : \'\' ]">{{ toTitleCase(column.label) }}<span :class="sortKeyClasses(column)"></span></div>\
			</div>',

	data: function() {
  		return {

	  		currentPage: 1,
	  	}
  	},

  	methods: {
  		sortBy: function(column) {
  			//var sortKey = column.name;
			// var reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;

			if(! column.isSortable)
			{
				return false;
			} 
  			this.$dispatch('table-sorted', column.name);

			
			// var sortKey = sortKey;			
			// this.refreshTable(sortKey, reverse);
			// this.reverse = reverse;
			// this.sortKey = sortKey;
		},

		sortKeyClasses: function(column) {
			if(! column.isSortable)
			{
				return false;
			}
			var key = column.name;
			var classes = [
					'icon'
				];

			if(key == this.sortKey)
			{
				classes.push('text-warning');
				if(this.reverse > 0)
				{
					classes.push('icon-chevron-up');
					return classes;
				}
				classes.push('icon-chevron-down');
				return classes;
			}
			classes.push('icon-chevron-up', 'text-muted');
			return classes;
		},
	}
}