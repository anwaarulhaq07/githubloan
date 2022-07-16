<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Transaction_history;
use Carbon\Carbon;
use Illuminate\Http\Request;

class bankTransacControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $bank = Bank::find($id);
        return view('admin.bank.transaction', compact('bank'));
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

        $new_balance = $request->current_balance +  $request->add_balance;

        $bank = Bank::where('id', $request->id)->first();
        $bank->id = $request->id;
        $bank->name = $request->name;
        $bank->bank_name = $request->bank_name;
        $bank->total_balance = $new_balance;
        $bank->save();

        $date = Carbon::now()->format('Y-m-d');
        $history = new Transaction_history();
        $history->bank_id =$request->id;
        $history->from = $request->name;
        $history->amount = $request->add_balance;
        $history->date = $date;
        $history->status = 'Add Balance';
        $history->save();
        return redirect()->route('admin.bank_index');
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
        $bank = Bank::find($id);
        $banks = Bank::all();
        return view('admin.bank.send',compact('bank','banks'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function share(Request $request)
    {
        // return $request;
        //
        // Deduct money from sending Account
        $bank = Bank::where('id', $request->id)->first();
        $bank->id = $request->id;
        $bank->name = $request->name;
        $bank->bank_name = $request->bank_name;
        $new_balance = $request->current_balance -  $request->shared_balance;
        $bank->total_balance = $new_balance;
        $bank->save();

        // Add money in Receiving Account
        $bank = Bank::where('id', $request->receiver)->first();
        $r_name = $bank->name;

        $bank->id = $request->receiver;
        // $bank->name = $request->name;
        // $bank->bank_name = $request->bank_name;
        $new_balance = $bank->total_balance +  $request->shared_balance; 
        $bank->total_balance = $new_balance;
        $bank->save();

        // Add Transaction History of Receiver
        $date = Carbon::now()->format('Y-m-d');
        $history = new Transaction_history();
        $history->bank_id = $request->receiver;
        $history->from = $request->name;
        $history->amount = $request->shared_balance;
        $history->purpose = $request->purpose;
        $history->date = $date;
        $history->status = 'Received';
        $history->save();

        // Add Transaction History of Sender
        $date = Carbon::now()->format('Y-m-d');
        $history = new Transaction_history();
        $history->bank_id =$request->id;
        $history->from = $r_name;
        $history->amount = $request->shared_balance;
        $history->purpose = $request->purpose;
        $history->date = $date;
        $history->status = 'Transferred';
        $history->save();

        return redirect()->route('admin.bank_index');


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
