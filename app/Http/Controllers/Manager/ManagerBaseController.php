<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ManagerBaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->manager = $this->user->manager;
    }
}
