<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use App\Models\Balloon;
use App\Models\Balloon_installment;
use App\Models\Transaction_history; 
use Symfony\Component\HttpFoundation\Response;
use Gate;
use Auth;

class BalloonController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('balloon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_id = Auth::user()->id;
        $balloon = Balloon::where('parent_id',$user_id)->with('user')->get();
        return view('admin.balloon_loan.index',compact('balloon'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('balloon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user_id = Auth::user()->id;
        $user = User::where('parent_id',$user_id)->whereHas('roles', function ($q) {
            $q->where('title', 'Customer');
        })->get();
        // return $user;
        $banks = Bank::where('user_id',$user_id)->get();
        return view('admin.balloon_loan.create', compact('user','banks'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_date = date("m-d-Y",strtotime($request->start_date));
        $loan = new Balloon;
		$loan->bank_id = $request->receiver;
        $loan->user_id = $request->user_id;
        $loan->parent_id = $request->parent_id;
        $loan->amount = $request->amount;
        $loan->downpayment = $request->downpayment; 
        $loan->extra_fee = $request->extra_fee; 
        $loan->percentage = $request->percentage;
        $loan->balloon_period = $request->balloon_terms; 
        $loan->loan_terms = $request->loan_terms;
        $loan->property_address = $request->property_address;
        $loan->starttime = $start_date;
        $loan->save();
        $balloon_id = $loan->id;

        // Add downpayment in the select bank
        $bank = Bank::where('id', $request->receiver)->first();
        $bank->id = $request->receiver;
        $new_balance = $bank->total_balance +  $request->downpayment + $request->extra_fee;
        $bank->total_balance = $new_balance;
        $bank->save();

        // Add Transaction History of Receiver in bank 
        $history = new Transaction_history();
        $history->bank_id = $request->receiver;
        $history->parent_id = $request->parent_id;
        $customer = User::where('id',$request->user_id)->first();
        $history->from = $customer->name;
        $history->amount = $request->downpayment;
        $history->extra_fee = $request->extra_fee;
        $history->date = $start_date;
        $history->status = 'Received';
        $history->purpose = '(Balloon)Downpayment';
        $history->save();

        // Balloon loan start

        $balloon_amount = $request->amount - $request->downpayment ;
        $balloon_interest = $request->percentage;
        $balloon_interest = (int) filter_var($balloon_interest, FILTER_SANITIZE_NUMBER_INT);
        
        
        $strtdate = $request->start_date;
        
        $term = 12;
        
        //creating period
        $terms_term = $request->loan_terms * $term;
        $balloon_term = $request->balloon_terms * $term;
        $monthly_balloon_interest = ($balloon_interest / 100) / $term;
        $total_month = $terms_term + $balloon_term;
        // making percentage in $interest
        //Creating the Denominator
        // $deno = 1 - 1 / pow((1 + $monthly_balloon_interest), $balloon_term);
        $deno = pow((1 + $monthly_balloon_interest),$total_month)/(pow((1 + $monthly_balloon_interest),$total_month)-1);
        
        $j = $balloon_amount;
        $array = [];
        $i = 1;
        $x = 1;
        while ($x < $balloon_term+1){
            //Payment for a period
            $Monthly_payment = ($balloon_amount * $monthly_balloon_interest) * $deno;

            //Interest for a Period
            $periodInterest = $j * $monthly_balloon_interest;

            //Principal for a Period
            // $principal = $Monthly_payment - $periodInterest;
            $principal = 0;
            $principal = number_format($principal, 2, '.', '');

            //Getting the Balance
            // $j = $j - $principal;
            // $j = number_format($j, 2, '.', ''); 

                $array[] = [
                    'actual_num_amount'=>$i,
                    'install_id'=>$i,
                    'payment' => $Monthly_payment,
                    'Interest' => $periodInterest,
                    'principal' => $principal,
                    'balance' => $j
                ];

            $i++;
            $x++;
        }
//   dd($array);


        foreach ($array as $data) {

            //   dd($data);
            $installment = new Balloon_installment;
            $installment->actual_num_amount =$data['actual_num_amount'];
            $installment->user_id = $request->user_id;
            $installment->balloon_id = $balloon_id;
            $installment->install_id =$data['install_id'];
            $installment->schedule_payment = $data['payment'];
            $installment->total_payment = $data['principal'] + $data['Interest'];
            $installment->type = 1;
            $installment->status = 0;
            $installment->interest = $data['Interest'];
            $installment->principal = $data['principal'];  
            $installment->balance = $data['balance'];
            $installment->save();
        }

            if($i > 0){
                $l = $i;
            }else{
                $i = 1;
            }
            $term_amount = $balloon_amount; 
        // return $term_amount;
        

        $term_interest = $request->percentage;
        $term_interest = (int) filter_var($term_interest, FILTER_SANITIZE_NUMBER_INT);
        
        
        $strtdate = $request->start_date;
        
        $term = 12;
        
        //creating period
        $loan_terms = $request->loan_terms * $term;
        $balloon_term = $request->balloon_terms * $term;
        $total_month = $loan_terms + $balloon_term;
        // making percentage in $interest
        $monthly_term_interest = ($term_interest / 100) / $term;
        //Creating the Denominator
        // $deno = 1 - 1 / pow((1 + $monthly_term_interest), $period);
        $deno = pow((1 + $monthly_term_interest),$total_month)/(pow((1 + $monthly_term_interest),$total_month)-1);
        
        
        $j = $term_amount;
        $array = [];
        $i = 1;
        $x = 1;
        while ($x < $loan_terms+1) {
            //Payment for a period
            $Monthly_payment = ($term_amount * $monthly_term_interest) * $deno;

            //Interest for a Period
            $periodInterest = $j * $monthly_term_interest;

            //Principal for a Period
            $principal = $Monthly_payment - $periodInterest;

            //Getting the Balance
            $j = $j - $principal;

                $array[] = [
                    'actual_num_amount'=> $l,
                    'install_id'=>$i,
                    'payment' => $Monthly_payment,
                    'Interest' => $periodInterest,
                    'principal' => $principal,
                    'balance' => $j
                ];

            $l++;
            $i++;
            $x++;
        }
    //   dd($array);


    foreach ($array as $data) {

    //   dd($data);
    $installment = new Balloon_installment;
    $installment->actual_num_amount =$data['actual_num_amount'];
    $installment->balloon_id = $balloon_id;
    $installment->user_id = $request->user_id;
    $installment->install_id =$data['install_id'];
    $installment->schedule_payment = $data['payment'];
    $installment->total_payment = $data['principal'] + $data['Interest'];
    $installment->type = 2;
    $installment->status = 0;
    $installment->interest = $data['Interest'];
    $installment->principal = $data['principal'];  
    $installment->balance = $data['balance'];
    $installment->save();
    }
    
        return redirect()->route('admin.balloon_index');

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
        $balloon = Balloon::find($id); 
        // return $id;
        $balloon->delete();
        $balloon_installment = Balloon_installment::where('balloon_id',$id)->delete();
        
        // $balloon_installment->delete();
        // return $balloon_installment;
        return redirect()->route('admin.balloon_index');
    }
    // public function report($id){
    //     $balloon = Balloon::find($id);
    //     $interest=Balloon_installment::where([['status','=','1'],['balloon_id','=',$id],])->sum('interest');
    //     $latefee=Balloon_installment::where([['status','=','1'],['balloon_id','=',$id],])->sum('late_fee');
    //     $data = $interest + $latefee;

    //     return view('admin.balloon_loan.report',compact('data','balloon'));

    // }
    public function report_summary($id) 
    {
        
        $balloon = Balloon::find($id);
        $installment = Balloon_installment::where('balloon_id', $id)->get();
        $interest=Balloon_installment::where([['status','=','1'],['balloon_id','=',$id],])->sum('interest');
        $latefee=Balloon_installment::where([['status','=','1'],['balloon_id','=',$id],])->sum('late_fee');
        $payment = Balloon_installment::where([['status','=','1'],['balloon_id','=',$id],])->sum('total_payment');
        $total_paid = $payment + $latefee;
        $total_profit = $interest;
        $t_amount = $balloon->amount - $balloon->downpayment; 

        return view('admin.balloon_loan.report', compact('installment','t_amount','total_profit','balloon','total_paid'));

    }
    public function balloon_complete_report() 
    {
        $balloon = Balloon::with('user')->get();
        $loan_amount = Balloon::all()->sum('amount');
        $downpayment = Balloon::all()->sum('downpayment');
        $total_5_points = Balloon::all()->sum('extra_fee');
        $total_interest = Balloon_installment::where('status',1)->sum('interest');
        $total_payment = Balloon_installment::where('status',1)->sum('total_payment');
        $late_fee = Balloon_installment::where('status',1)->sum('late_fee');
        $total_profit = $total_interest;
        $total_paid = $late_fee + $total_payment;
        return view('admin.balloon_loan.complete_report',compact('balloon', 'loan_amount', 'downpayment', 'total_profit','total_5_points','total_paid'));
    }
}
