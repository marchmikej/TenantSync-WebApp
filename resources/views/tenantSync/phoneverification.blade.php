@if ($device->user_id == $user->id)
	Do you want this device to receive notifications.
@else
	This device is currently assigned to another user if you want it assigned to {{$user->email}} please select Update Notification.
	<br>To keep select Home.
@endif
<form method="POST" action="/api/phoneverify/{{ $device->id }}">
	@if ($device->verified == 2)
	  	<input type="radio" name="notify" value="yes"> Yes
		<br>
  		<input type="radio" name="notify" value="no" checked> No
   	@else
	  	<input type="radio" name="notify" value="yes" checked> Yes
		 <br>
  		<input type="radio" name="notify" value="no"> No
    @endif
	<div>
        <button type="submit">Update Notification</button>
    </div>
</form>

@if ($device->user_id != $user->id)
	<form method="GET" action="/home">
		<div>
        	<button type="submit">Home</button>
    	</div>
	</form>
@endif