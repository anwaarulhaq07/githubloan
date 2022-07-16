<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMortageRequest;
use App\Http\Requests\StoreMortageRequest;
use App\Http\Requests\UpdateMortageRequest;
use App\Models\Mortage;
use App\Models\Bank;
use App\Models\Transaction_history;
use App\Models\installment;
use App\Models\Balloon_installment;
use App\Models\Payment; 
use App\Models\User;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MortageController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('mortage_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_id = Auth::user()->id;
        $mortages = Mortage::where('parent_id',$user_id)->with(['user'])->get();
        return view('admin.mortages.index', compact('mortages'));
    }

    public function create() 
    {
        abort_if(Gate::denies('mortage_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_id = Auth::user()->id;
        $users = User::where('parent_id',$user_id)->whereHas('roles', function ($q) {
            $q->where('title', 'Customer');
        })->get();
        $banks = Bank::where('user_id',$user_id)->with('user')->get();
        // return $users;
        return view('admin.mortages.create', compact('users', 'banks'));
    }

    public function store(Request $request)
    {
        // return $request->all();
        $start_date = date("m-d-Y",strtotime($request->start_date));
        $mortage = new Mortage;
		$mortage->parent_id = $request->parent_id;
		$mortage->bank_id = $request->receiver;
        $mortage->loandamoutn = $request->loandamoutn;  
        $mortage->downpayment = $request->downpayment;
        $mortage->extra_fee = $request->extra_fee; 
        $mortage->total_paid = 0;
        $mortage->total_profit = 0;
        $mortage->percentage = $request->percentage;
        $mortage->loan_terms = $request->loan_terms;
        $mortage->property_address = $request->property_address;
        $mortage->start_date = $start_date;
        $mortage->user_id  = $request->user_id;
        $mortage->save();
        $mortId = $mortage->id; 

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
        $history->purpose = '(Mortgage)Downpayment';
        $history->save();


        //GETTING DATA FROM DB
        //GETTING USER INPUTS AND ASSIGNING THEM TO VARIABLES
        
        $amount = $request->loandamoutn - $request->downpayment ;

        $interest = $request->percentage;
        $interest = (int) filter_var($interest, FILTER_SANITIZE_NUMBER_INT); 
        // return $interest;

        $year = $request->loan_terms;
        $strtdate = $request->start_date;

        $term = 12;

        //creating period
        $period = $term * $year;
        $monthlyinterest = ($interest / 100) / $term;

        // making percentage in $interest
        //Creating the Denominator
        $deno = 1 - 1 / pow((1 + $monthlyinterest), $period);
        // $deno = pow((1 + $monthlyinterest),$period)/(pow((1 + $monthlyinterest),$period)-1);
        
        $j = $amount;
        $array = [];
        $i = 1;
        while ($j > 0.001) {
            //Payment for a period
            $payment = ($amount * $monthlyinterest) / $deno;
            // return $payment;
            // $payment = number_format($payment, 2, '.', '');

            //Interest for a Period
            $periodInterest = $j * $monthlyinterest;
            // $periodInterest = number_format($periodInterest, 2, '.', '');

            //Principal for a Period
            $principal = $payment - $periodInterest;
            // $principal = number_format($principal, 2, '.', '');
            //Getting the Balance 
            //  $j -= (int)$principal; 
            // $j = number_format($j, 2, '.', '');
            if ($j >= 0) {
                $array[] = [
                    'install_id'=>$i,
                    'payment' => $payment,
                    'Interest' => $periodInterest,
                    'principal' => $principal,
                    'balance' => $j
                ];
            }
            $j = $j - $principal;
            $i++;
        }
        // dd($array);
        foreach ($array as $data) {
            $installment = new installment;
            $installment->mortage_id = $mortId;
            $installment->user_id = $request->user_id;
            $installment->status = 0;
            $installment->install_id =$data['install_id'];
            $installment->payment_dues = $data['payment'];
            $installment->interest_dues = $data['Interest'];
            $installment->principal_dues = $data['principal'];
            $installment->balance = $data['balance'];
            $installment->save();
        }


        return redirect()->route('admin.mortages.index');
    }

    public function edit(Mortage $mortage)
    {
        abort_if(Gate::denies('mortage_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mortage->load('user');
        return view('admin.mortages.edit', compact('mortage', 'users'));
    }

    public function update(Request $request, Mortage $mortage)
    {
        $mortage->update($request->all());


          // GETTING USER INPUTS AND ASSIGNING THEM TO VARIABLES
          $amount = $request->loandamoutn;
          $year = $request->loan_terms;
        //   $strtdate = $request->start_date;

          $interest = $request->percentage;
          $interest = (int) filter_var($interest, FILTER_SANITIZE_NUMBER_INT);
  
          //creating period
          $term = 12;
          $period = $term * $year;
        
          $monthlyinterest = ($interest / 100) / $term;
  
          // making percentage in $interest
          //Creating the Denominator
          $deno = 1 - 1 / pow((1 + $monthlyinterest), $period);
  
          $j = $amount;
          $array = [];
  
          while ($j > 0) {
              //Payment for a period
              $payment = ($amount * $monthlyinterest) / $deno;
              $payment = number_format($payment, 2, '.', '');
  
              //Interest for a Period
              $periodInterest = $j * $monthlyinterest;
              $periodInterest = number_format($periodInterest, 2, '.', '');
  
              //Principal for a Period
              $principal = $payment - $periodInterest;
              $principal = number_format($principal, 2, '.', '');
              //Getting the Balance 
              $j = $j - $principal;
              $j = number_format($j, 2, '.', '');
              if ($j >= 0) {
                  $array[] = [
                      'payment' => $payment,
                      'Interest' => $periodInterest,
                      'principal' => $principal,
                      'balance' => $j
                  ];
              }
          }
          $installment = installment::where('mortage_id',$request->id)->get();
          foreach($installment as $data)
          {
              $data->delete();
          }

          foreach ($array as $data) {
            $installment = new installment;
              $installment->mortage_id = $request->id;
              $installment->payment_dues = $data['payment'];
              $installment->interest_dues = $data['Interest'];
              $installment->principal_dues = $data['principal'];
              $installment->balance = $data['balance'];
              $installment->save();
          }
        return redirect()->route('admin.mortages.index');
    }

    public function show(Mortage $mortage)
    {
        abort_if(Gate::denies('mortage_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mortage->load('user');

        return view('admin.mortages.show', compact('mortage'));
    }

    public function destroy(Mortage $mortage)
    {

        abort_if(Gate::denies('mortage_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
         $mortage->delete();
        $payment = Payment::where('mortage_id',$mortage->id)->get();
        foreach($payment as $data)
        {
            $data->delete();
        }
        $installment = installment::where('mortage_id',$mortage->id)->get();
        foreach($installment as $data)
        {
            $data->delete();
        }

        return back();
    }

    public function massDestroy(MassDestroyMortageRequest $request)
    {
        Mortage::whereIn('id', request('ids'))->delete();
        installment::where('mortage_id',request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function report($id){

        $mortage = Mortage::find($id);
        
        $installment = installment::where('mortage_id', $id)->get();
        $interest=installment::where([['status','=','1'],['mortage_id','=',$id],])->sum('interest_dues');
        $total_interest=installment::where('mortage_id','=', $id)->sum('interest_dues');
        $latefee=installment::where([['status','=','1'],['mortage_id','=',$id],])->sum('late_fee');
        $total_payment_due=installment::where([['status','=','1'],['mortage_id','=',$id],])->sum('principal_dues');
         $total_profit = $interest;
        $total_paid = $total_payment_due + $latefee + $interest;
        return view('admin.mortages.report',compact('installment','total_profit','mortage', 'total_paid','total_interest'));


    }
    public function complete_mortage_report()
    {
        $mortages = Mortage::with(['user'])->get();
            
        $total_loan = Mortage::all()->sum('loandamoutn');
        $total_downpayment = Mortage::all()->sum('downpayment');
        $total_5_points = Mortage::all()->sum('extra_fee');
        $total_interest = installment::where('status',1)->sum('interest_dues');
        $paid = installment::where('status',1)->sum('payment_dues');
        $late_fee = installment::where('status',1)->sum('late_fee');
        $total_paid = $paid + $late_fee;
        $total_profit = $total_interest;

        return view('admin.mortages.complete_report', compact('mortages', 'total_loan', 'total_downpayment', 'total_profit','total_paid','total_5_points'));
        
    }
}
