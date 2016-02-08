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
        $with = isset($this->input['with']) ? $this->input['with'] : [];
        
        $set = isset($this->input['set']) ? $this->input['set'] : [];

        $devices = Device::getDevicesForUser($this->user, $with);

        $devices = DeviceMutator::set($set, $devices);

        return $devices;
    }
}
