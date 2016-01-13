<?php namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Utilities\State;
use App\Services\RoiCalculator;
use App\Http\Controllers\Controller;


class CalculatorController extends Controller {

    public function __construct(RoiCalculator $roiCalculator)
    {
        $this->roiCalculator = $roiCalculator;
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $states = State::all();
        return view('TenantSync::manager/calculator', compact('states'));
    }

    public function estimateRoi()
    {
        $roi = $this->roiCalculator->cashOnCashRoi($this->input['purchasePrice'], $this->input['rent'], $this->input['expenses'], $this->input['taxes']);
        return $roi;
    }

    public function calculatePayments($rate, $months, $principal) 
    {
        $loan = $principal;// - $down;
        $payment = floor(($loan*$rate/(1-pow(1+$rate,(-1*$months))))*100)/100;
        return $payment;
        //return number_format($rate * $principal * pow((1 + $rate), $months) / (1 - pow((1 + $rate), $months)));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
