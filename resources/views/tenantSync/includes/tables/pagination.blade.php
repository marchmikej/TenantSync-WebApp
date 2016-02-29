<div class="col-sm-4 col-sm-offset-4 text-center">
	<button class="btn btn-clear text-primary"
		v-if="currentPage > 1"
		@click="previousPage()" 
	>
		<span class="icon icon-chevron-left"></span>
	</button>
	<button class="btn btn-clear text-primary"
		v-if="currentPage < lastPage"
		@click="nextPage()"
	>
		<span class="icon icon-chevron-right"></span>
	</button>
</div>