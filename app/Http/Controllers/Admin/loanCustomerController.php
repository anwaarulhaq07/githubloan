<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction_history;
use App\Models\Loan_installment;
use Illuminate\Http\Request;
use App\Models\Loan_payment;
use App\Models\Auto_loan;
use App\Models\Bank;

class loanCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $loan = Auto_loan::with('payments')->get();
        // return $loan;


        return view('admin.auto_loan.auto-customer.index', compact('loan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return $request;
        $payment = new Loan_payment;
        $payment->loan_id = $request->loan_id;
        $payment->install_id = $request->install_id;
        $payment->payment = $request->begin_balance;
        $payment->late_fee = $request->late_fee;
        $payment->date = $request->date;
        $payment->save();

         $pay_payment = $request->begin_balance +$request->late_fee;

        $bank = Bank::where('id', $request->receiver)->first();
        $bank->id = $request->receiver;
        // $bank->name = $request->name;
        // $bank->bank_name = $request->bank_name;
        $new_balance = $bank->total_balance +  $pay_payment;
        $bank->total_balance = $new_balance;
        $bank->save();

        // Add Transaction History of Receiver
        $history = new Transaction_history();
        $history->bank_id = $request->receiver;
        $history->from = $request->name;
        $history->amount = $pay_payment;
        $history->date = $request->date;
        $history->status = 'Received';
        $history->save();
        //----------------------------------------------------------------------------------------------------
        //get data from Loan_payment table
        $payment = Loan_payment::where('loan_id', $request->loan_id)->get()->sum('payment');
        $max_install_id = Loan_payment::where('loan_id', $request->loan_id)->get()->max('install_id');


        // return  $install_id;

        //get data from Auto_loan of that user
        $loan = Auto_loan::where('id', $request->loan_id)->get();
        $amount = $loan[0]->amount;
        $t_month = $loan[0]->loan_terms * 12;
        $interest = $loan[0]->percentage;
        $interest = (int) filter_var($interest, FILTER_SANITIZE_NUMBER_INT);
        $t_interest = $amount / 100 * $interest;
        $t_amount = $t_interest + $amount;
        $installment = $t_amount / $t_month;

        $remain_amount =  $t_amount - $payment;
        $R_period = $remain_amount / $installment;

        // return $R_period;
        $t_interest = $amount / 100 * $interest;
        $t_amount = $t_interest + $amount;
        $array = [];

        $j = $remain_amount;
        $i = $max_install_id + 1;

        while ($j > 0.5) {
            // $installment = $t_amount/$period;
            $mnthly_intrest = $t_interest / $t_month;
            $principal = $amount / $t_month;
            $end_balance = $j - $installment;

            $installment = number_format($installment, 2, '.', '');
            $mnthly_intrest = number_format($mnthly_intrest, 2, '.', '');
            $principal = number_format($principal, 2, '.', '');
            $balance = number_format($end_balance, 2, '.', '');
            if ($j >= 0) {
                $array[] = [
                    'install_id' => $i,
                    'installment' => $installment,
                    'Interest' => $mnthly_intrest,
                    'principal' => $principal,
                    'balance' => $balance
                ];
                $j = $end_balance;
            }
            $i++;
        }
        // return $array;

        //update current installment in summary
        $installment = Loan_installment::where('install_id', $request->install_id)->where('loan_id', $request->loan_id)->first();
        $id = $request->install_id;
        if ($id == 1) {
            $last_install = Loan_installment::where('install_id', $id)->where('loan_id', $request->loan_id)->first();
            $last = $last_install->begin_balance + $last_install->end_balance;
        } else {
            $last_install = Loan_installment::where('install_id', $id - 1)->where('loan_id', $request->loan_id)->first();
            $last = $last_install->end_balance;
        }
        $end_balan = $last - $request->begin_balance;
        $interest = $request->begin_balance/100*$interest;
        $interest = number_format($interest, 2, '.', '');
        $principal =  $request->begin_balance -  $interest;
        $principal = number_format($principal, 2, '.', '');

        // return $end_balan;
        $installment = Loan_installment::where('install_id', $id)->where('loan_id', $request->loan_id)->first();
        $installment->begin_balance = $request->begin_balance;
        $installment->late_fee = $request->late_fee;
        $installment->interest_dues = $interest;
        $installment->principal_dues = $principal;
        $installment->status = 1;
        $installment->end_balance =  $end_balan;
        $installment->save();

        // $R_installment = Loan_installment::where('install_id','>',$max_install_id)->where('loan_id',$request->loan_id)->groupBy('id')->get();
		$id = $request->install_id;
        $id = (int)$id;
        $R_installment = Loan_installment::where('install_id', '>', $id)->where('loan_id', $request->loan_id)->get();

        // return $R_installment;

        foreach ($R_installment as $data) {
            $data->delete();
        }

        //update remainig installment in summary
        foreach ($array as $data) {
            $installment = new Loan_installment;
            $installment->loan_id = $request->loan_id;
            $installment->status = 0;
            $installment->install_id = $data['install_id'];
            $installment->begin_balance = $data['installment'];
            $installment->interest_dues = $data['Interest'];
            $installment->principal_dues = $data['principal'];
            $installment->end_balance = $data['balance'];
            $installment->save();
        }


        return back();

        // return redirect()->route('admin.loancustomerindex');
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
