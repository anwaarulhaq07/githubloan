<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mortage;
use App\Models\Bank;
use App\Models\User;
use App\Models\Payment;
use App\Models\installment;
use Illuminate\Http\Request;
use Gate;
use Auth;

class detailController extends Controller 
{
    //
    public function detail($id) 
    {
        // return $request;

        $user_id1 = Auth::user()->id;
        $installment = installment::where('mortage_id', $id)->get();
        $actual_num_amount = installment::where('mortage_id', $id)->orderBy('id','DESC')->pluck('install_id')->first();
        $banks = Bank::where('user_id',$user_id1)->get();
        $mortage = Mortage::where('parent_id',$user_id1)->where('id', $id)->get(); 
        $user_id = $mortage[0]->user_id;
        $user = User::where('id',$user_id)->first(); 

        // return $mortage;

        $install_id = $id;

        return view('admin.detail.detail', compact('installment','mortage','banks','install_id','user','actual_num_amount'));
    }
    // public function detail(Request $request)
    // {

    //     $mortage = Mortage::where('id', $request->id)->get();

    //     // GETTING USER INPUTS AND ASSIGNING THEM TO VARIABLES
    //     $amount = $mortage[0]->loandamoutn;
    //     $interest = $mortage[0]->percentage;
    //     $year = $mortage[0]->loan_terms;
    //     $strtdate = $mortage[0]->start_date;

    //     $term = 12;

    //     //creating period
    //     $period = $term * $year;
    //     $monthlyinterest = ($interest / 100) / $term;

    //     // making percentage in $interest
    //     //Creating the Denominator
    //     $deno = 1 - 1 / pow((1 + $monthlyinterest), $period);

    //     $j = $amount;
    //     $array = [];

    //     while ($j > 0) {
    //         //Payment for a period
    //         $payment = ($amount * $monthlyinterest) / $deno;
    //         $payment = number_format($payment, 2, '.', '');

    //         //Interest for a Period
    //         $periodInterest = $j * $monthlyinterest;
    //         $periodInterest = number_format($periodInterest, 2, '.', '');

    //         //Principal for a Period
    //         $principal = $payment - $periodInterest;
    //         $principal = number_format($principal, 2, '.', '');
    //         //Getting the Balance 
    //         //  $j -= (int)$principal;
    //         $j = $j - $principal;
    //         $j = number_format($j, 2, '.', '');
    //         if ($j >= 0) {
    //             $array[] = [
    //                 'payment' => $payment,
    //                 'Interest' => $periodInterest,
    //                 'principal' => $principal,
    //                 'balance' => $j
    //             ];
    //         }
    //     }
    //     dd($array);
    //     return view('admin.detail.detail', compact('array', 'mortage'));
    // }

    public function paid(Request $request){
        $payment = Payment::where('mortage_id',$request->id)->get();
        return view('admin.detail.paid', compact('payment'));

    }

    public function master()
    {
        return view('layouts.master');
    }

    public function mortage_pay(Request $request, $id)  
    {
        // return $id;
        $user_id1 = Auth::user()->id;
        $installment = installment::where('install_id', $id)->where('mortage_id', $request->mortage_id)->where('interest_dues', $request->interest_dues)->first();
        $banks = Bank::where('user_id',$user_id1);
        $install_id = $request->id;
        $loan = Mortage::where('parent_id',$user_id1)->where('user_id', $request->user_id)->first();
        $user_id = $loan->user_id;
        $user = User::where('id',$user_id)->first();
        $t_amount = $loan->amount - $loan->downpayment;

        return view('admin.detail.mortage_pay', compact('installment','banks','install_id','user'));

    }
}
