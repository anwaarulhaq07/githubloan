<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan_installment;
use App\Models\Loan_payment;
use App\Models\User;
use App\Models\Bank;
use App\Models\Auto_loan;


class loanlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $installment = Loan_installment::where('loan_id', $request->id)->get();
        $banks = Bank::all();
        $id = $request->id;
        $loan = Auto_loan::where('id', $id)->get();
        $user_id = $loan[0]->user_id;
        $user = User::where('id',$user_id)->first();

        $interest = (int) filter_var($loan[0]->percentage, FILTER_SANITIZE_NUMBER_INT);
        $t_interest = $loan[0]->amount/100*$interest;
        $t_amount = $t_interest + $loan[0]->amount;
       
       
        return view('admin.auto_loan.list.index', compact('installment','banks','t_amount','id','user'));

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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $payment = Loan_payment::where('loan_id',$request->id)->get();
        // return  $payment;
        return view('admin.auto_loan.list.paid', compact('payment'));
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
