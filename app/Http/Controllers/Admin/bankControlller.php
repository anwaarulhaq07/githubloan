<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Balloon;
use App\Models\Role;
use App\Models\Mortage;
use App\Models\User; 
use Gate;
use Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Transaction_history;


class bankControlller extends Controller 
{
    /**
     * Display a listing of the resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('bank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_id = Auth::user()->id;
        $user = User::with('roles')->where('id',$user_id)->first();
        $users_role = $user->roles[0]->title;
        if($user && $users_role == 'Admin')
        {
            $bank = Bank::with('user')->get();
            
        }
        else{
            $user_id =Auth::user()->id;
            $bank = Bank::with('user')->where('user_id',$user_id)->get();
        }

        return view('admin.bank.index', compact('bank'));
        // return view('admin.bank.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('bank_add'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user_id = Auth::user()->id;
        $user = User::with('roles')->where('id',$user_id)->first();
        $users_role = $user->roles[0]->title;
        if($user && $users_role == 'Admin')
        {
            $user_role = User::with('roles')->whereHas('roles',function($q){
                $q->where('title','Banker');
            })->get();
        }
        else{
            $user_role =array(Auth::user()); 
        }
        // return $user_role;
        return view('admin.bank.create', compact('user_role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $bank = new Bank();
        $bank->user_id = $request->user_id;
        $bank->account_title = $request->account_title;
        $bank->bank_name = $request->bank_name;
        $bank->total_balance = $request->total_balance;
        $bank->save();

        return redirect()->route('admin.bank_index');
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
        //
        $bank = Bank::find($id);
        $bank->delete();
        return redirect()->route('admin.bank_index');
    }
    public function history($id)
    {
        //
        $id = $id;
        $history = Transaction_history::where('bank_id', $id)->get();
        $total_amount = Transaction_history::where('bank_id',$id)->sum('amount');
        $total_profit = Transaction_history::where('bank_id',$id)->sum('total_profit'); 
		$motage_5_points = Mortage::where('bank_id', $id)->sum('extra_fee');
        $balloon_5_points = Balloon::where('bank_id', $id)->sum('extra_fee');
        $total_5_points = $balloon_5_points +$motage_5_points;
        $bank = Bank::find($id);
        return view('admin.bank.tansaction_history.index', compact('history', 'id','bank','total_amount','total_profit','total_5_points'));
    }

    public function complete_history()
    {
        //

        $user_id = Auth::user()->id;
        $user = User::with('roles')->where('id',$user_id)->first();
        $users_role = $user->roles[0]->title;
        if($user && $users_role == 'Admin')
        {
            // $bank = Bank::with('user')->get();
            $history = Transaction_history::all();
            $total_amount = Transaction_history::all()->sum('amount');
            $total_profit = Transaction_history::all()->sum('total_profit');
            $motage_5_points = Mortage::all()->sum('extra_fee');
            $balloon_5_points = Balloon::all()->sum('extra_fee');
            $total_5_points = $balloon_5_points +$motage_5_points;
            
        }
        else{
            // return "hello";
            $user_id =Auth::user()->id;
            $banks_ids = Bank::where('user_id',$user_id)->pluck('id');
            $history = Transaction_history::where('bank_id',$banks_ids)->get();
            $total_amount = Transaction_history::where('bank_id',$banks_ids)->sum('amount');
            $total_profit = Transaction_history::where('bank_id',$banks_ids)->sum('total_profit');
            $motage_5_points = Mortage::where('parent_id',$user_id)->sum('extra_fee');
            $balloon_5_points = Balloon::where('parent_id',$user_id)->sum('extra_fee');
            $total_5_points = $balloon_5_points +$motage_5_points;
        }
        
        return view('admin.bank.tansaction_history.complete_history', compact('history','total_amount','total_profit','total_5_points'));
    }

    public function limit_history(Request $request)
    {
        //
        // return $request->all();
        $from_date = date("m-d-Y",strtotime($request->from_date));
        $to_date = date("m-d-Y",strtotime($request->to_date));
        $history = Transaction_history::whereBetween('date', [$from_date,$to_date])->get();
        // return $limit_history;
        $total_amount = Transaction_history::whereBetween('date', [$from_date,$to_date])->sum('amount');
        $total_profit = Transaction_history::whereBetween('date', [$from_date,$to_date])->sum('total_profit');
		$motage_5_points = Mortage::whereBetween('start_date', [$from_date,$to_date])->sum('extra_fee');
        $balloon_5_points = Balloon::whereBetween('starttime', [$from_date,$to_date])->sum('extra_fee');
        $total_5_points = $balloon_5_points +$motage_5_points;
        // $bank = Bank::all();
        return view('admin.bank.tansaction_history.complete_history', compact('history','total_amount','total_profit','from_date','to_date','total_5_points'));
    }

    public function bank_limit_history(Request $request) 
    {
        //
        $id = $request->bank_id;
        $from_date = date("m-d-Y",strtotime($request->from_date));
        $to_date = date("m-d-Y",strtotime($request->to_date));
        $history = Transaction_history::where('bank_id', $id)->whereBetween('date', [$from_date,$to_date])->get();
        $total_amount = Transaction_history::where('bank_id', $id)->whereBetween('date', [$from_date,$to_date])->sum('amount');
        $total_profit = Transaction_history::where('bank_id', $id)->whereBetween('date', [$from_date,$to_date])->sum('total_profit');
		$motage_5_points = Mortage::whereBetween('start_date', [$from_date,$to_date])->sum('extra_fee');
        $balloon_5_points = Balloon::whereBetween('starttime', [$from_date,$to_date])->sum('extra_fee');
        $bank = Bank::find($id);
        return view('admin.bank.tansaction_history.index', compact('history', 'id','bank','total_amount','total_profit','from_date','to_date','balloon_5_points'));
    }

    public function delhistory(Request $request)
    {

        $history = Transaction_history::where('bank_id', $request->bank_id)->get();
        // $bank = Bank::with('historys')->where('id',$request->bank_id)->get();

        foreach($history as $data) 
        {
            $data->delete();
        }
        return back();
    }
}
