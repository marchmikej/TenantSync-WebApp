Vue.component('modal', {
	props: ['title'],

	template: '<div v-if="visible" class="vue-modal row">\
	<div id="modal" class="modal-dialog">\
		<div class="modal-content col-sm-12 p-b">\
			<div class="modal-header row">\
	        	<button @click="hide" class="col-sm-1 icon icon-cross btn btn-clear" :class="{\'col-sm-offset-11\' : !title}"></button>\
	        	<h4 v-if="title" class="modal-title">{{ title}}</h4>\
	      	</div>\
		  	<div class="modal-body">\
		  		<slot name="one"></slot>\
		  		<slot name="two"></slot>\
		  		<slot name="three"></slot>\
		  		<slot name="four"></slot>\
		  	</div>\
		</div><!-- /.modal-content -->\
	</div><!-- /.modal-dialog -->\
</div>',

	data: function() {
		return {
			visible: false,
		};
	},

	events: {
		'show-modal' : function() {
			this.show();
		},

		'hide-modal': function() {
			this.hide();
		},

		'toggle-modal': function() {
			this.visible = !this.visible;
		}
	},

	methods: {
		show: function() {
			this.visible = true;
		},

		hide: function() {
			this.visible = false;
			this.$dispatch('modal-hidden');
		},
	},

})