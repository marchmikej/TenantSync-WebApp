<?php

namespace App\Http\Controllers\Api;

use TenantSync\Models\RentBill;
use App\Http\Controllers\Controller;
use TenantSync\Mutators\RentBillMutator;

class RentBillController extends Controller {
	
	/**
	 * Initialize necessary components
	 */
	public function __construct()
	{
		parent::__construct();

		$this->with = isset($this->input['with']) ? $this->input['with'] : [];
        
        $this->set = isset($this->input['set']) ? $this->input['set'] : [];
        
        $this->fromDate = isset($this->input['from']) ? $this->input['from'] : '-1 month';
	}

	/**
	 * Get all rent bills for user
	 *
	 * @return void
	 * @author 
	 **/
	public function index()
	{
        $rentBills = RentBill::getRentBillsForUser($this->user, $this->with, $this->fromDate);

        $rentBills = RentBillMutator::set($this->set, $rentBills);

        return $rentBills;
	}
}