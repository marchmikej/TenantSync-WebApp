<recent-messages inline-template>
	<div class="col-sm-6 p-l-md">
		<div class="card row">
			<div class="col-sm-12">
	
					<h3 class="card-header">
						<div>
							Recent Messages

							<button 
								@click="previousPage" 
								:class="currentPage > 1 ? 'text-primary' : 'text-muted'" 
								class="btn-clear btn icon icon-chevron-left"
							>
							</button>

							<button 
								@click="nextPage" 
								:class="lastPage == currentPage ? 'text-muted' : 'text-primary'"
								class="btn-clear btn icon icon-chevron-right"
							>
							</button>

							<button 
								@click="newMessage()" 
								class=" btn btn-clear p-y-0"
							>
								<h3 class="m-a-0 text-primary icon icon-plus"></h3>
							</button>
						</div>
					</h3>
					
					<div class="row table-heading">
					<div class="col-sm-4">Unit</div>
					<div class="col-sm-6">Message</div>
					<div class="col-sm-2">Message</div>
				</div>
				<div class="table-body table-striped">
					<div 
						v-if="isInCurrentPage($index)"
						v-for="message in messages | orderBy 'created_at' -1" 
						class="table-row row"
					>
						<div class="col-sm-4"><a :href="'/'+ user().role +'/device/'+ message.device.id">@{{ message.device.property.address + ', ' + message.device.location }}</a></div>
						<div class="col-sm-6">
							<span 
								:class="['fa', message.from_device ? 'fa-arrow-down' : 'fa-arrow-up', message.from_device ? 'text-success' : 'text-danger']"
							>
							</span>
							@{{ message.body }}
						</div>
						<div class="col-sm-2">@{{ humanDate(message.created_at) }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	
	<modal :id="'message-modal'">
		<form id="message-form" class="form form-horizontal" slot="one">
			
			<div  class="form-group">
				<label class="control-label col-sm-3" for="payable">Send To</label>
				<div class="col-sm-9">
					<input v-model="forms.message.search" class="form-control col-sm-4" type="text" placeholder="Search..."/>
					<label class="control-label p-l">@{{ 'Devices selected: '+ _.size(forms.message.device_id) }}</label>
				</div>
			</div>
		
			<div class="well col-sm-9 col-sm-offset-3 scrollable" style="max-height: 150px;">
				<ul style="list-style-type: none;">
					<li 
						@click=""
					>
						<label>
							<input 
								@click.stop="toggleAllDevices($event)" 
								type="checkbox" 
							>
							All
						</label>
					</li>
					<li 
						v-for="property in properties | filterBy forms.message.search" 
						class="col-sm-12"
					>
						<label>
							<input 
								@click.stop="toggleDevicesInProperty($event)" 
								type="checkbox" 
								:data-name="'property-'+ property.id"
							>
							@{{ property.address }}
						</label>
		
						<ul style="list-style-type: none;">
							<li 
								v-for="device in property.devices" 
							>
								<input 
									@click.stop="toggleDeviceForMessage($event)"
									type="checkbox" 
									:data-id="device.id"
									:checked="_.contains(forms.message.device_id, device.id)"
								>
								@{{ device.location }}
							</li>
						</ul>
					</li>
				</ul>
			</div>
		
			<ts-textarea
				:name="message"
				:display="'Message'"
				:form="forms.message"
				:input.sync="forms.message.body"
			>
			</ts-textarea>
		
			<button 
				@click.prevent="sendMessage()" 
				class="col-sm-4 col-sm-offset-8 btn btn-primary form-control"
			>
				Send
			</button>
		
		</form>
	</modal>
</recent-messages>