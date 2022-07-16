<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auto_loan;
use App\Models\Loan_installment;
use App\Models\Loan_payment;
use App\Models\User;


class loanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
        $auto_loan = Auto_loan::with('user')->get();
        return view('admin.auto_loan.index', compact('auto_loan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = User::get();
        return view('admin.auto_loan.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loan = new Auto_loan;
        $loan->user_id = $request->user_id;
        $loan->amount = $request->amount;
        $loan->downpayment = $request->downpayment;
        $loan->percentage = $request->percentage;
        $loan->loan_terms = $request->loan_terms;
        $loan->starttime = $request->start_date;
        $loan->save();
        $loan_id = $loan->id;

        //GETTING USER INPUTS AND ASSIGNING THEM TO VARIABLES

        $amount = $request->amount - $request->downpayment;

        $interest = $request->percentage;
        $interest = (int) filter_var($interest, FILTER_SANITIZE_NUMBER_INT);

        //creating period
        $year = $request->loan_terms;
        $term = 12;
        $period = $term * $year;

        // making percentage in $interest
        $t_interest = $amount/100*$interest;
        $t_amount = $t_interest + $amount;
        $array = [];

            $j = $t_amount;
            $i = 1;

            while ($j>0) {
            $installment = $t_amount/$period;
            $mnthly_intrest = $t_interest/$period;
            $principal = $amount/$period;
            $end_balance = $j - $installment;

            $installment = number_format($installment, 2, '.', '');
            $mnthly_intrest = number_format($mnthly_intrest, 2, '.', '');
            $principal = number_format($principal, 2, '.', '');
            $balance = number_format($end_balance, 2, '.', '');
            $array[] = [
                'install_id'=>$i,
                'installment' => $installment,
                'Interest' => $mnthly_intrest,
                'principal' => $principal,
                'balance' => $balance
            ];
            $j = $end_balance;

            $i++;
        }
        // dd($array);


        foreach ($array as $data) {
            $installment = new Loan_installment;
            $installment->loan_id = $loan_id;
            $installment->status = 0;
            $installment->install_id =$data['install_id'];
            $installment->begin_balance = $data['installment'];
            $installment->interest_dues = $data['Interest'];
            $installment->principal_dues = $data['principal'];
            $installment->end_balance = $data['balance'];
            $installment->save();
        }


        return redirect()->route('admin.loanindex');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::get();
        $loan = Auto_loan::where('id', $id)->first();
        return view('admin.auto_loan.edit', compact('loan', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        // return $request;
        $loan = Auto_loan::find($request->id);
        $loan->update($request->all());
        $loan_id = $loan->id;
        // return $loan_id;

        // GETTING USER INPUTS AND ASSIGNING THEM TO VARIABLES
        $amount = $request->amount - $request->downpayment;

        $amount = $amount;
        $rate = $request->percentage / 100 / 12; // Monthly interest rate
        $term = $request->loan_terms * 12; // Term in months
        $emi = $amount * $rate * (pow(1 + $rate, $term) / (pow(1 + $rate, $term) - 1));
        $emi = number_format($emi, 2, '.', '');


        $j = $amount;
        $array = [];

        while ($j > 0) {

            //Interest for a Period
            $interest_Component  =  $rate * $j;
            $interest_Component = number_format($interest_Component, 2, '.', '');

            //Principal for a Period
            $principal_Component = $emi - $interest_Component;
            $principal_Component = number_format($principal_Component, 2, '.', '');


            //ending of this & beginning of the next month
            $jend =   $j - $principal_Component;
            $jend = number_format($jend, 2, '.', '');


            if ($j >=  0.50) {
                $array[] = [
                    'beginning' => $j,
                    'emi' => $emi,
                    'Interest' => $interest_Component,
                    'principal' => $principal_Component,
                    'end_balance' => $jend,
                ];
            }
            $j =   $j - $principal_Component;
        }
        $installment = Loan_installment::where('loan_id', $request->id)->get();
        foreach ($installment as $data) {
            $data->delete();
        }
        // dd($array);
        foreach ($array as $data) {
            $installment = new Loan_installment();
            $installment->loan_id = $loan_id;
            $installment->begin_balance = $data['beginning'];
            $installment->emi = $data['emi'];
            $installment->interest_dues = $data['Interest'];
            $installment->principal_dues = $data['principal'];
            $installment->end_balance = $data['end_balance'];
            $installment->save();
        }

        return redirect()->route('admin.loanindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;


        $loanpayment = Loan_payment::where('loan_id', $id)->get();
        foreach ($loanpayment as $data) {
            $data->delete();
        }
        $loan = Auto_loan::where('id', $id)->first();
        // return $loan;
        $loan->delete();
        $installment = Loan_installment::where('loan_id', $id)->get();
        foreach ($installment as $data) {
            $data->delete();
        }

        return redirect()->route('admin.loanindex');
    }
}
