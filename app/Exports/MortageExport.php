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

class MortageExport implements Fromview
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): view
    {
        $id = $this->id;
        $mortage = Mortage::find($id);
        
        $installment = installment::where('mortage_id', $id)->get();
        $interest=Installment::where([['status','=','1'],['mortage_id','=',$id],])->sum('interest_dues');
        $total_interest=Installment::where('mortage_id','=',$id)->sum('interest_dues');
        $latefee=Installment::where([['status','=','1'],['mortage_id','=',$id],])->sum('late_fee');
		$total_payment_due=installment::where([['status','=','1'],['mortage_id','=',$id],])->sum('principal_dues');
        $total_paid = $interest + $latefee + $total_payment_due;
        return view('admin.mortages.excel',compact('installment','interest','mortage','total_interest','total_paid'));

        // return view('admin.balloon_loan.excel', compact('installment','t_amount','data','balloon'));
    }
}
