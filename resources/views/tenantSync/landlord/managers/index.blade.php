@extends('TenantSync::landlord/layout')

@section('content')

<managers-table inline-template>
	<div class="row card" id="managers">
		<div class="col-sm-12">
				<h4 class="card-header">
					Managers<button @click="" class="btn btn-clear p-y-0"><a href="/landlord/managers/create"><h3 class="icon icon-plus text-primary m-a-0"></h3></a></button>
				</h4>
			<!-- <table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers> -->
	
			<div class="table-body table-striped">
				<div v-for="manager in managers" class="table-row row">
					<div @click="confirm({method:'deleteManager', id: manager.id})" class="col-sm-1 text-left btn icon icon-minus text-danger p-a-0"></div>
					<div class="col-sm-3">@{{ manager.first_name + ' ' + manager.last_name}}</div>
					<div class="col-sm-2">@{{ manager.position ? manager.position : '-' }}</div>
					<div class="col-sm-3">@{{ manager.email ? manager.email : '-' }}</div>
					<div class="col-sm-2">@{{ manager.phone ? manager.phone : '-' }}</div>
					<div @click="toggleProperties(manager.id)" class="col-sm-1 text-right btn icon icon-plus text-primary p-a-0"></div>
	
					<div :data-manager-id="manager.id" class="sub-table col-sm-12" style="display: none;">
						<div class="table-row">
							<div @click="generateModal(manager.id)" class="col-sm-2 col-sm-offset-1 text-success" style="cursor: pointer;"><span class="icon icon-plus"></span>&nbsp;Add Property ...</div>
						</div>
						<div v-for="property in manager.properties" class="table-row">
							<div class="col-sm-1 text-right text-warning">@{{ property.devices ? property.devices.length : '-' }}</div>
							<div class="col-sm-3">@{{ property.address ? property.address : '-' }}</div>
							<div class="col-sm-2">@{{ property.city ? property.city  : '-' }}</div>
							<div class="col-sm-3">@{{ property.zip ? property.zip : '-' }}</div>
							<div @click="removeProperty(manager, property)" class="col-sm-2 col-sm-offset-1"><span class="btn icon icon-minus text-danger"></span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<!--// MODAL -->
		<div v-show="modal.show" id="modal" class="vue-modal" style="display: none;">
		  	<div class="modal-dialog">
		    	<div class="modal-content">
			      	<!-- <div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title text-info">Edit Transaction</h4>
			      	</div> -->
			      	<form @keyup.enter="submitModal" class="form form-horizontal">
			      		<div class="modal-body">
						<h4 v-if="modal.show" class="card-header">@{{ modal.manager.first_name + ' ' + modal.manager.last_name }}</h4>
						
						<div class="form-group">
							<label class="control-label col-sm-3">Properties</label>
							<div class="col-sm-9">
								<select v-model="modal.properties" id="property-select" class="form-control" style="width: 100%;" multiple>
									<option v-for="property in properties | whereNotIn modal.manager.properties 'id'" :value="property.id">@{{ property.address }}</option>
								</select>
							</div>
						</div>
						
	
			      		</div>
				      	<div class="modal-footer">
				        	<button @click="hideModal" type="button" class="btn btn-default">Close</button>
				        	<button  @click="submitModal" type="button" class="btn btn-primary">Add Properties</button>
				      	</div>
			      	</form>
		    	</div><!-- /.modal-content -->
		  	</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
</managers-table>

@endsection

@section('scripts')

<script>
Vue.config.debug = true;

Vue.component('managers-table', TSTable.extend({
	// el: '#app',

	data: function() {
		return {
			// sortKey: 'first_name',

			// reverse: -1,

			// currentPage: 1,

			// search: null,

			columns: [
				{
					name: 'first_name',
					label: 'First Name',
					width: 'col-sm-6',
					isSortable: false
				},
				{
					name: 'Last Name',
					label: 'Name',
					width: 'col-sm-6',
					isSortable: false
				},
				{
					name: 'position',
					label: 'Position',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'email',
					label: 'Email',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'phone',
					label: 'Phone',
					width: 'col-sm-2',
					isSortable: true
				}
			],

			managers: [],

			properties: [],

			modal: {
				show: false,
				manager: {},
				properties: [],
			},
		};
	},

	ready: function() {
		this.fetchManagers();
		this.fetchProperties();
		var select = $('#property-select');
		select.select2({
			theme: "bootstrap",
		});
	},

	methods: {
		fetchManagers: function() {
			var data = {
				with: ['properties', 'properties.devices', 'user'],
			};

			this.$http.get('/api/managers', data)
			.success(function(managers) {
				this.managers = managers;
			});
		},

		fetchProperties: function() {

			this.$http.get('/api/properties/')
			.success(function(properties) {
				this.properties = properties;
			});
		},

		generateModal: function(id) {
			var manager = _.find(this.managers, function(manager) { return manager.id == id; });

			this.modal.show = true;
			this.modal.manager = manager;
			// this.$http.post('/landlord/managers/')
			// .success(function(manager) {

			// });
		},

		submitModal: function() {
			var data = {
				properties: $('#property-select').val(),
				manager_id: this.modal.manager.id,
			};

			this.$http.patch('/api/managers/properties', data)
				.success(function(properties) {
					this.fetchManagers();
					this.hideModal();

					// var manager = _.find(this.managers, function(manager) {
					// 	return manager.id == this.modal.manager.id;
					// }.bind(this));
				});
		},

		hideModal: function() {
			this.modal = {
				manager: {},
				properties: [],
				show: false,
			};
			$('#property-select').select2('val', '');
		},

		removeProperty: function(manager, property) {
			var data = {
				properties: [property.id],
				manager_id: manager.id,
			};
			this.$http.delete('/api/managers/properties', data)
				.success(function(result) {
					manager.properties.$remove(property);
					this.hideModal();
				});
		},



		deleteManager: function(id) {

			var manager = _.find(this.managers, function(manager) {
				return manager.id == id;
			});

			this.$http.delete('/api/managers/'+ id)
			.success(function(managers) {
					this.managers.$remove(manager);
			});	
		},

		toggleProperties: function(id) {
			$('[data-manager-id= '+ id +']').toggle();
		},
	}



}));

</script>

@endsection