<?php

namespace App\Http\Controllers\Api;

use TenantSync\Models\Device;
use TenantSync\Mutators\DeviceMutator;
use App\Http\Controllers\Controller;

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
