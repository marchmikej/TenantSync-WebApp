<?php

namespace App\Http\Controllers\Api;

use Gate;
use TenantSync\Models\Device;
use App\Http\Controllers\Controller;
use TenantSync\Mutators\DeviceMutator;

class DeviceController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->deviceMutator = new DeviceMutator;
    }

    public function index()
    {
        $with = [];
        if(isset($this->input['with'])) {
            $with = $this->input['with'];
        }

        $devices = Device::getDevicesForUser($this->user, $with);
        $devices = $this->deviceMutator->set('rent_owed', $devices);
        $devices = $this->deviceMutator->set('address', $devices);
        return $devices;
    }
}
