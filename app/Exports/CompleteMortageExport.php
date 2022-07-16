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

class CompleteMortageExport implements Fromview
{
   
    /**
    * @return \Illuminate\Support\Collection 
    */
    public function view(): view
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

        return view('admin.mortages.complete_report_excel', compact('mortages', 'total_loan', 'total_downpayment', 'total_profit','total_paid','total_5_points'));
    }
}
