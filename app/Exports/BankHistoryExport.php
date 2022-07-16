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
use App\Models\Transaction_history;
use App\Models\Bank;

class BankHistoryExport implements Fromview
{
    protected $from;
    protected $to;
    protected $bank_id;

    public function __construct($from,$to,$bank_id)
    {
        $this->from = $from;
        $this->to = $to;
        $this->bank_id = $bank_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): view
    {
        $from_date = $this->from;
        $to_date = $this->to;
        $bank_id = $this->bank_id;
        
        
        if($from_date > 0){
            $history = Transaction_history::where('bank_id', $bank_id)->whereBetween('date', [$from_date,$to_date])->get();
            $total_amount = Transaction_history::where('bank_id', $bank_id)->whereBetween('date', [$from_date,$to_date])->sum('amount');
            $total_profit = Transaction_history::where('bank_id', $bank_id)->whereBetween('date', [$from_date,$to_date])->sum('total_profit');
             $motage_5_points = Mortage::where('bank_id', $bank_id)->whereBetween('start_date', [$from_date,$to_date])->sum('extra_fee');
            $balloon_5_points = Balloon::where('bank_id', $bank_id)->whereBetween('starttime', [$from_date,$to_date])->sum('extra_fee');
            $total_5_points = $balloon_5_points +$motage_5_points;
			$bank = Bank::find($bank_id);
        }else {
            $history = Transaction_history::where('bank_id',$bank_id)->get();
            // return $limit_history;
            $total_amount = Transaction_history::where('bank_id',$bank_id)->sum('amount');
            $total_profit = Transaction_history::where('bank_id',$bank_id)->sum('total_profit');
			$motage_5_points = Mortage::where('bank_id', $bank_id)->sum('extra_fee');
            $balloon_5_points = Balloon::where('bank_id', $bank_id)->sum('extra_fee');
            $total_5_points = $balloon_5_points +$motage_5_points;
            $bank = Bank::find($bank_id);
            }
        // $bank = Bank::all();
        return view('admin.bank.tansaction_history.bank_history_excel', compact('history','total_amount','total_profit','bank','total_5_points'));
    }
}
