<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\User;
use App\Models\Mortage;
use App\Models\Balloon;
use App\Models\Balloon_installment;

class UserExport implements Fromview
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
        $balloon = Balloon::find($id);
        $installment = Balloon_installment::where('balloon_id', $id)->get();
        $interest=Balloon_installment::where([['status','=','1'],['balloon_id','=',$id],])->sum('interest');
        $late_fee=Balloon_installment::where([['status','=','1'],['balloon_id','=',$id],])->sum('late_fee');
        $payment = Balloon_installment::where([['status','=','1'],['balloon_id','=',$id],])->sum('total_payment');
        $total_paid = $payment + $late_fee;
        $total_profit = $interest;
        $t_amount = $balloon->amount - $balloon->downpayment;  

        return view('admin.balloon_loan.excel', compact('installment','t_amount','total_profit','balloon','total_paid'));
    }
}
