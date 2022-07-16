<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use App\Models\Balloon_payment; 
use App\Models\Auto_loan;
use App\Models\Balloon;
use App\Models\Balloon_installment;
use App\Models\Transaction_history;
use App\Models\Loan_installment; 
use Gate;
use Auth;


class BalloonInstallmentController extends Controller 
{


// show balloon installment of the customer
    public function index($id)  
    {
        $user_id1 = Auth::user()->id;
        $installment = Balloon_installment::where('balloon_id', $id)->get(); 
        $actual_num_amount = Balloon_installment::where('balloon_id', $id)->orderBy('id','DESC')->pluck('actual_num_amount')->first();
        $banks = Bank::where('user_id',$user_id1)->get();
        $loan = Balloon::where('parent_id',$user_id1)->where('id', $id)->first();
        $user_id = $loan->user_id;
        $user = User::where('id',$user_id)->first();
        $t_amount = $loan->amount - $loan->downpayment;

        return view('admin.balloon_loan.Installment.installment', compact('installment','banks','t_amount','id','user','actual_num_amount'));

    }



    public function store(Request $request)
    {
        //
        $start_date = date("m-d-Y",strtotime($request->date));
        $payment = new Balloon_payment;
        $payment->ballon_id = $request->loan_id;
        $payment->parent_id = $request->parent_id;
        $payment->install_id = $request->install_id;
        $payment->payment = $request->payment;
        $payment->late_fee = $request->late_fee;
        $payment->note = $request->note;
        $payment->date = $start_date;
        $payment->save(); 
        $paid_amount = $request->payment;
        $id = $request->loan_id;


        // return $principal;
        $pay_payment = $request->payment +$request->late_fee;

        $bank = Bank::where('id', $request->receiver)->first();
        $bank->id = $request->receiver;
        // $bank->name = $request->name;
        // $bank->bank_name = $request->bank_name;
        $new_balance = $bank->total_balance +  $pay_payment;
        $bank->total_balance = $new_balance;
        $bank->save();

        // status update
        $installment = Balloon_installment::where('type',$request->type_id)->where('status',0)->where('install_id', $request->install_id)->where('balloon_id', $id)->first();
        $installment->status = 1;
        $installment->late_fee =  $request->late_fee;
        $installment->note =  $request->note;
        $installment->principal =  $paid_amount - $installment->interest;
        $installment->save();

        $installment_balance = $installment->balance - $installment->principal;
        // Add Transaction History of Receiver 
        $total_interest = Balloon_installment::where('install_id', $request->install_id)->where('balloon_id', $request->mortage_id)->where('status',1)->sum('interest');
        $total_late_fee = Balloon_installment::where('install_id', $request->install_id)->where('balloon_id', $id)->where('status',1)->sum('late_fee');
        $history = new Transaction_history();
        $history->bank_id = $request->receiver;
        $history->parent_id = $request->parent_id;
        $history->from = $request->name;
        $history->amount = $pay_payment;
        $total_profit = $history->total_profit + $total_interest + $total_late_fee;
        $history->total_profit = $total_profit;
        $history->date = $start_date;
        $history->status = 'Received';
        $history->purpose = 'Loan Installment';
        $history->save();

        
        // data update start
        if($installment->balance == 0){
            $amount = $installment->balance;
        }else {
            $amount = $installment_balance;
        }

        //

         //Add total paid and profit
         $total_payment = Balloon_installment::where('install_id', $request->install_id)->where('balloon_id', $id)->where('status',1)->sum('total_payment');
         $total_interest = Balloon_installment::where('install_id', $request->install_id)->where('balloon_id', $id)->where('status',1)->sum('interest');
         $total_late_fee = Balloon_installment::where('install_id', $request->install_id)->where('balloon_id', $id)->where('status',1)->sum('late_fee');
         $balloon = Balloon::where('parent_id',$request->perant_id)->where('id',$id)->first();
         $total_paid = $balloon->total_paid + $total_payment + $total_late_fee;
         $total_profit = $balloon->total_profit + $total_interest;
         $balloon->total_paid = $total_paid;
         $balloon->total_profit = $total_profit;
         $balloon->save();
		
		  $total_payment = Balloon_installment::where('status', 0)->where('balloon_id', $id)->where('type',$request->type_id)->pluck('total_payment')->first();
        if($total_payment>$paid_amount){
        $remaining_amount = $total_payment - $paid_amount;
        $amount = $amount + $remaining_amount;
        }
        

        if($amount == 0){
            $installment = Balloon_installment::where('status', 0)->where('balloon_id', $id)->update(['status' => 1]);
        }else {

            $balloon = Balloon::where('parent_id',$request->perant_id)->where('id',$id)->first();
            $term = 12;
            $terms_term =  $balloon->loan_terms * $term;
            $balloon_term = $balloon->balloon_period * $term;
            // New formula
            if($amount > 0){
				if($paid_amount != $total_payment){
                if($balloon_term > 0 ){
                $balloon_interest = $balloon->percentage;
                $balloon_interest = (int) filter_var($balloon_interest, FILTER_SANITIZE_NUMBER_INT);

                $strtdate = $balloon->starttime; 

                //creating period
                $monthly_balloon_interest = ($balloon_interest / 100) / $term; 
                $total_month = $terms_term + $balloon_term;
                $paid_month = Balloon_installment::where('type',1)->where('balloon_id', $id)->where('status',1)->count();
                $remaining_balloon_month = $balloon_term - $paid_month;
                $deno = pow((1 + $monthly_balloon_interest),$total_month)/(pow((1 + $monthly_balloon_interest),$total_month)-1);
                // return $deno;

                $j = $amount;
                $array = [];
                $i = 1;
                $x = 1;

                $first_baloon_id =  Balloon_installment::where('balloon_id', $id)->where('status',0)->pluck('id')->first();
                
                while ($x < $remaining_balloon_month+1) {

                    // $total_payment = Balloon_installment::where('id',$first_baloon_id)->where('balloon_id', $id)->where('status',0)->pluck('total_payment')->first();
                    // $Monthly_payment = ($amount * $monthly_balloon_interest) * $deno;
                    
                    //Interest for a Period
                    $periodInterest = $j * $monthly_balloon_interest;
                    
                    //Principal for a Period
                    // $principal = $Monthly_payment - $periodInterest;
                    // $principal = $total_payment - $periodInterest;
                    $principal = 0;
                    $principal = number_format($principal, 2, '.', '');

                    $total_payment = $periodInterest + $principal;
                    
                    //Getting the Balance
                    // $j = $j - $principal;
                    // $j = number_format($j, 2, '.', '');
                    $array[] = [
                            // 'install_id'=>$install_id,
                            // 'payment' => $Monthly_payment,
                            // 'first_baloon_id' => $first_baloon_id,
                            'total_payment' => $total_payment,
                            'interest' => $periodInterest,
                            'principal' => $principal,
                            'balance' => $j
                        ];
                        
                        $first_baloon_id ++;
                        $x++;
                    }
                    
                    
                    // dd($array);
                    $first_baloon_id1 =  Balloon_installment::where('balloon_id', $id)->where('status',0)->pluck('id')->first();
                    // return $first_baloon_id1;

                    $total_count = Balloon_installment::where('type',1)->where('balloon_id', $id)->where('status',0)->count();
                    // return [$first_baloon_id1,$total_count,count($array)] ;

                    for ($i = 0; $i < $total_count; $i++) {
                            $baloon = Balloon_installment::where('id',$first_baloon_id1)->where('status',0)->update($array[$i]);
                            $first_baloon_id1++;
                        }
                        

                }
                if($terms_term > 0){

                    
                    $term_amount = $amount;
                    
            
                    $term_interest = $balloon->percentage;
                    $term_interest = (int) filter_var($term_interest, FILTER_SANITIZE_NUMBER_INT);
                    
                    
                    $strtdate = $request->start_date; 
                    
                    $term = 12;
                    
                    //creating period
                    $loan_terms = $balloon->loan_terms * $term;
                    $balloon_term = $balloon->balloon_period * $term;
                    $total_month = $loan_terms + $balloon_term;
                    $paid_month = Balloon_installment::where('type',2)->where('balloon_id', $id)->where('status',1)->count();
                    $remaining_month = $loan_terms - $paid_month;
                    // making percentage in $interest
                    $monthly_term_interest = ($term_interest / 100) / $term;
                    //Creating the Denominator
                    // $deno = 1 - 1 / pow((1 + $monthly_term_interest), $period);
                    $deno = pow((1 + $monthly_term_interest),$total_month)/(pow((1 + $monthly_term_interest),$total_month)-1);
                    
                    $j = $term_amount;
                    $array = [];
                    $i = 1;
                    $x = 1;

                      // Total Amount
                      if($request->type == 2){
                        $first_baloon_id =  Balloon_installment::where('type',$request->type)->where('balloon_id', $id)->where('status',0)->pluck('id')->first();
                    }else{
                        $first_baloon_id =  Balloon_installment::where('type',2)->where('balloon_id', $id)->where('status',0)->pluck('id')->first();
                    }


                    while ($x < $remaining_month+1) {
                        //Payment for a period
                        // $Monthly_payment = ($term_amount * $monthly_term_interest) * $deno;
                        if($request->type == 2){
                            $total_payment = Balloon_installment::where('id',$first_baloon_id)->where('type',$request->type)->where('balloon_id', $id)->where('status',0)->pluck('total_payment')->first();
                        }else {
                            $total_payment = Balloon_installment::where('id',$first_baloon_id)->where('type',2)->where('balloon_id', $id)->where('status',0)->pluck('total_payment')->first();
                            
                        }
            
                        //Interest for a Period
                        $periodInterest = $j * $monthly_term_interest;
            
                        //Principal for a Period
                        $principal = $total_payment - $periodInterest;
            
                        //Getting the Balance
                        
                        $array[] = [
                            // 'payment' => $total_payment,
                            'Interest' => $periodInterest,
                            'principal' => $principal,
                            'balance' => $j
                        ];
                        $j = $j - $principal;
                        $first_baloon_id++;
                        $x++;
                    }
                //   dd($array);

                  $first_baloon_id1 =  Balloon_installment::where('type',2)->where('balloon_id', $id)->where('status',0)->pluck('id')->first();
                    // return $first_baloon_id1;

                    $total_count = Balloon_installment::where('type',2)->where('balloon_id', $id)->where('status',0)->count();

                    for ($i = 0; $i < $total_count; $i++) {
                            $baloon = Balloon_installment::where('id',$first_baloon_id1)->where('status',0)->update($array[$i]);
                            $first_baloon_id1++;
                        }
                
            }
            
            // Last Installment
              $total_payment = Balloon_installment::where('type',2)->where('balloon_id', $id)->where('status',0)->pluck('total_payment')->first();
            $total_payment = round($total_payment);
            
            $r = Balloon_installment::where('balloon_id',$id)->where('status',0)->where('balance' ,'<=', (int)$total_payment)->delete();
            $last = Balloon_installment::orderBy('id','DESC')->where('balloon_id',$id)->limit(1)->first();
            $last_balance = $last->balance - $last->principal;
            $installment = new Balloon_installment;
            $installment->actual_num_amount =$last->actual_num_amount+1;
            $installment->user_id = $last->user_id;
            $installment->balloon_id = $last->balloon_id;
            $installment->install_id =$last->install_id+1;
            $installment->schedule_payment = $last->schedule_payment;
            $installment->total_payment = $last_balance;
            $installment->type = 2;
            $installment->status = 0;
            $installment->interest = $last_balance * $monthly_term_interest;
            $installment->principal = $last_balance ;  
            $installment->balance = $last_balance;
            $installment->save();
				
            return redirect()->route('admin.balloon_summary',[$id]);

					}else{
            return redirect()->route('admin.balloon_summary',[$id]);
        }
            }else{
                // return "same";
                return redirect()->route('admin.balloon_summary',[$id]);
            }
            // End new formula
            }
    

        
        //----------------------------------------------------------------------------------------------------
        //get data from Loan_payment table
        // $payment = Loan_payment::where('loan_id', $request->loan_id)->get()->sum('payment');
        // $max_install_id = Loan_payment::where('loan_id', $request->loan_id)->get()->max('install_id');


        // // return  $install_id;

        // //get data from Auto_loan of that user
        // $loan = Auto_loan::where('id', $request->loan_id)->get();
        // $amount = $loan[0]->amount;
        // $t_month = $loan[0]->loan_terms * 12;
        // $interest = $loan[0]->percentage;
        // $interest = (int) filter_var($interest, FILTER_SANITIZE_NUMBER_INT);
        // $t_interest = $amount / 100 * $interest;
        // $t_amount = $t_interest + $amount;
        // $installment = $t_amount / $t_month;

        // $remain_amount =  $t_amount - $payment;
        // $R_period = $remain_amount / $installment;

        // // return $R_period;
        // $t_interest = $amount / 100 * $interest;
        // $t_amount = $t_interest + $amount;
        // $array = [];

        // $j = $remain_amount;
        // $i = $max_install_id + 1;

        // while ($j > 0.5) {
        //     // $installment = $t_amount/$period;
        //     $mnthly_intrest = $t_interest / $t_month;
        //     $principal = $amount / $t_month;
        //     $end_balance = $j - $installment;

        //     $installment = number_format($installment, 2, '.', '');
        //     $mnthly_intrest = number_format($mnthly_intrest, 2, '.', '');
        //     $principal = number_format($principal, 2, '.', '');
        //     $balance = number_format($end_balance, 2, '.', '');
        //     if ($j >= 0) {
        //         $array[] = [
        //             'install_id' => $i,
        //             'installment' => $installment,
        //             'Interest' => $mnthly_intrest,
        //             'principal' => $principal,
        //             'balance' => $balance
        //         ];
        //         $j = $end_balance;
        //     }
        //     $i++;
        // }
        // // return $array;

        // //update current installment in summary
        // $installment = Loan_installment::where('install_id', $request->install_id)->where('loan_id', $request->loan_id)->first();
        // $id = $request->install_id;
        // if ($id == 1) {
        //     $last_install = Loan_installment::where('install_id', $id)->where('loan_id', $request->loan_id)->first();
        //     $last = $last_install->begin_balance + $last_install->end_balance;
        // } else {
        //     $last_install = Loan_installment::where('install_id', $id - 1)->where('loan_id', $request->loan_id)->first();
        //     $last = $last_install->end_balance;
        // }
        // $end_balan = $last - $request->begin_balance;
        // $interest = $request->begin_balance/100*$interest;
        // $interest = number_format($interest, 2, '.', '');
        // $principal =  $request->begin_balance -  $interest;
        // $principal = number_format($principal, 2, '.', '');

        // // return $end_balan;
        // $installment = Loan_installment::where('install_id', $id)->where('loan_id', $request->loan_id)->first();
        // $installment->begin_balance = $request->begin_balance;
        // $installment->late_fee = $request->late_fee;
        // $installment->interest_dues = $interest;
        // $installment->principal_dues = $principal;
        // $installment->status = 1;
        // $installment->end_balance =  $end_balan;
        // $installment->save();

        // // $R_installment = Loan_installment::where('install_id','>',$max_install_id)->where('loan_id',$request->loan_id)->groupBy('id')->get();
		// $id = $request->install_id;
        // $id = (int)$id;
        // $R_installment = Loan_installment::where('install_id', '>', $id)->where('loan_id', $request->loan_id)->get();

        // // return $R_installment;

        // foreach ($R_installment as $data) {
        //     $data->delete();
        // }

        // //update remainig installment in summary
        // foreach ($array as $data) {
        //     $installment = new Loan_installment;
        //     $installment->loan_id = $request->loan_id;
        //     $installment->status = 0;
        //     $installment->install_id = $data['install_id'];
        //     $installment->begin_balance = $data['installment'];
        //     $installment->interest_dues = $data['Interest'];
        //     $installment->principal_dues = $data['principal'];
        //     $installment->end_balance = $data['balance'];
        //     $installment->save();
        // }


        return back();

        // return redirect()->route('admin.loancustomerindex');
    }

    // show balloon paid installment of the customer
    public function balloon_paid_installment(Request $request){
        $payment = Balloon_payment::where('ballon_id',$request->id)->get(); 
        // return  $payment;
        return view('admin.balloon_loan.Installment.paid', compact('payment'));
    }
    //reprt section

    public function install_pay(Request $request, $id)  
    {
        // return $id;
        $user_id1 = Auth::user()->id;
        $installment = Balloon_installment::where('install_id', $id)->where('balloon_id', $request->balloon_id)->where('interest', $request->interest)->first();
        $banks = Bank::where('user_id',$user_id1);
        $install_id = $request->id;
        $loan = Balloon::where('parent_id',$user_id1)->where('user_id', $request->user_id)->first();
        $user_id = $loan->user_id;
        $user = User::where('id',$user_id)->first();
        return view('admin.balloon_loan.Installment.install_pay', compact('installment','banks','install_id','user'));

    }
   

   
}