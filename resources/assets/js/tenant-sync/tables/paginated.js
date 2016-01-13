module.exports = {
	props: [],

	template: '\
		<div class="col-sm-4 col-sm-offset-4 text-center">\
			<button class="btn btn-clear text-primary"\
				v-if="paginated.current_page > 1"\
				@click="fetchTransactions(paginated.current_page - 1, sortKey, reverse)" \
			>\
				<span class="icon icon-chevron-left"></span>\
			</button>\
			<button class="btn btn-clear text-primary"\
				v-if="paginated.last_page > 1"\
				@click="fetchTransactions(paginated.current_page + 1, sortKey, reverse)"\
			>\
				<span class="icon icon-chevron-right"></span>\
			</button>\
		</div>\
	',

}