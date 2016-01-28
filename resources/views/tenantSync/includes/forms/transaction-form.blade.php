
<transaction-form inline-template>
	<form @keyup.enter="submit" class="form form-horizontal">
		<div class="form-group">
			<label class="control-label col-sm-3" for="payable">Apply To</label>
			<div class="col-sm-9">
				<input v-model="payable.selected" class="form-control col-sm-8" type="text" style="border: none;" readonly />
				<input v-model="payable.search" class="form-control col-sm-4" type="text" name="payable" placeholder="Search..."/>
			</div>
		</div>
	
		<div v-show="payable.search" class="well col-sm-9 col-sm-offset-3" style="max-height: 150px; overflow-y: scroll;">
			<ul class="list-select">
				<li @click.stop="setPayable('user')"><strong>General</strong></li>
				<li @click.stop="setPayable('property', property.id, property.address)" v-for="(key, property) in properties | search payable.search" class="col-sm-12">
					<strong>@{{ property.address }}</strong>
					<ul>
						<li @click.stop="setPayable('device', device.id, property.address + ', ' + device.location)" v-for="device in property.devices" >
							@{{ device.location }}
						</li>
					</ul>
				</li>
			</ul>
		</div>
	
		<div v-if="payable.type == 'device'" class="form-group">
			<label class="control-label col-sm-3" for="is_rent">Rent Payment</label>
			<div class="col-sm-9">
				<input v-model="is_rent" class="form-control" type="checkbox" name="is_rent"/>
			</div>
		</div>
	
		<div class="form-group">
			<label class="control-label col-sm-3" for="amount">Amount</label>
			<div class="col-sm-9">
				<input id="amount" class="form-control" type="text" name="amount" placeholder="Amount" v-model="amount"/>
			</div>
		</div>
	
		<div class="form-group">
			<label class="control-label col-sm-3" for="description">Description</label>
			<div class="col-sm-9">
				<input class="form-control" type="text" name="description" placeholder="Description" v-model="description"/>
			</div>
		</div>
	
		<div class="form-group">
			<label class="control-label col-sm-3" for="date">Date</label>
			<div class="col-sm-9">
				<input class="form-control" type="date" name="date" placeholder="mm/dd/yyyy" v-model="date" />
			</div>
		</div>
	</form>
</transaction-form>