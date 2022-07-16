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

class CompleteHistoryExport implements Fromview
{
    protected $from;
    protected $to;

    public function __construct($from,$to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): view
    {
        $from_date = $this->from;
        $to_date = $this->to;
 
            if($from_date > 0){
                $history = Transaction_history::whereBetween('date', [$from_date,$to_date])->get();
                $total_amount = Transaction_history::whereBetween('date', [$from_date,$to_date])->sum('amount');
                $total_profit = Transaction_history::whereBetween('date', [$from_date,$to_date])->sum('total_profit');
				$motage_5_points = Mortage::whereBetween('start_date', [$from_date,$to_date])->sum('extra_fee');
        		$balloon_5_points = Balloon::whereBetween('starttime', [$from_date,$to_date])->sum('extra_fee');
        		$total_5_points = $balloon_5_points +$motage_5_points;
            }else {
                $history = Transaction_history::all();
                $total_amount = Transaction_history::all()->sum('amount');
                $total_profit = Transaction_history::all()->sum('total_profit');
				$motage_5_points = Mortage::all()->sum('extra_fee');
        		$balloon_5_points = Balloon::all()->sum('extra_fee');
        		$total_5_points = $balloon_5_points +$motage_5_points;
            }
        // $bank = Bank::all();
        return view('admin.bank.tansaction_history.complete_history_excel', compact('history','total_amount','total_profit','total_5_points'));
    }
}
