Vue.mixin({

  	data: function() {
  		return {
	  		sortKey: '',

	  		reverse: 1,

	  		paginate: 15,
	  	}
  	},

  	methods: {
  		sortBy: function(index) {
			if(! this.columns[index].isSortable)
			{
				return false;
			} 

			var sortKey = this.columns[index].name;
			this.reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;
			this.sortKey = sortKey;
		},

		sortKeyClasses: function(index) {
			if(! this.columns[index].isSortable)
			{
				return false;
			}

			var sortKey = this.columns[index].name;
			var classes = [
					'icon'
				];

			if(sortKey == this.sortKey)
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

		generateUrlVars: function(includes) {
			var include = $.param(includes);
			return include;
		},
	}
});