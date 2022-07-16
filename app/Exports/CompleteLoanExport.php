<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\User;
use App\Models\Mortage;
use App\Models\Balloon;
use App\Models\Balloon_installment; 
use App\Models\installment; 

class CompleteLoanExport implements Fromview
{
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): view
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
        return view('admin.balloon_loan.complete_report_excel',compact('balloon', 'loan_amount', 'downpayment', 'total_profit','total_5_points','total_paid'));
    }
}
