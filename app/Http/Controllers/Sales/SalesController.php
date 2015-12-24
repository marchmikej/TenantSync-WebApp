<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        if($this->user->role != 'sales')
        {
            return abort(403, 'Unauthorized action.');
        }
    }

}
