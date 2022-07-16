<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;
use App\Models\User;
use App\Models\Mortage;
use App\Models\installment;
use App\Models\Balloon;
use App\Models\Balloon_installment;
use Gate;
use Auth;
class AuthCustomer extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response  
     */
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $parent_id = Auth::user()->id;
        $users = User::where('parent_id', $parent_id)->whereHas('roles', function ($q) {
            $q->where('title', 'Customer');
        })->get();

        return view('admin.authcustomer.index', compact('users')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $parent_id = Auth::user()->id;
        

        return view('admin.authcustomer.create', compact('parent_id'));
        // return view('admin.authcustomer.index');

      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $auth_id = Auth::user()->id;
        $us = User::where('parent_id',$auth_id)->where('email',$request->email)->get();
        if($us->count())
        {
            return redirect()->back()->with('error','User already exist.');
        }
        else
        {
        $user = User::create($request->all());
        $user->roles()->sync(3);
        }
       

        

        return redirect()->route('admin.customer_index');
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
       $user = User::find($id);

        return view('admin.authcustomer.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request;
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->route('admin.customer_index');
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
        $user = User::find($id);
        $user->delete();
        Mortage::where('user_id',$id)->delete();
        installment::where('user_id',$id)->delete();
        Balloon::where('user_id',$id)->delete();
        Balloon_installment::where('user_id',$id)->delete();
        
        return redirect()->route('admin.customer_index');

    }

    
    public function customer_history_mortage($id) 
    {
        abort_if(Gate::denies('mortage_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $id = $id;
        $total_collect = installment::find($id);
        $mortages = Mortage::with(['user'])->where('user_id',$id)->get();
        return view('admin.authcustomer.history.mortage_history', compact('mortages','id'));
    }

    public function complete_cumtomer_history_mortage($id)  
    {
        
        $installment = installment::where('user_id', $id)->get();
        $user = User::find($id);

        $total_loan = Mortage::where('user_id',$id)->sum('loandamoutn');
        $total_downpayment = Mortage::where('user_id',$id)->sum('downpayment');
        $total_interest = installment::where('user_id',$id)->where('status',1)->sum('interest_dues');
        $late_fee = installment::where('user_id',$id)->where('status',1)->sum('late_fee');
        $total_payment_due=installment::where([['status','=','1'],['user_id','=',$id],])->sum('principal_dues');
        $total_profit = $total_interest + $late_fee;
        $total_paid = $total_payment_due + $late_fee;

        return view('admin.authcustomer.history.complete_mortage_history', compact('installment','total_loan','total_downpayment','total_profit','total_paid','user'));

    }


    public function customer_history_balloon($id)
    {
        $id = $id;
        $balloon = Balloon::with('user')->where('user_id',$id)->get();
        return view('admin.authcustomer.history.balloon_history',compact('balloon','id'));
    }

    public function complete_cumtomer_history_balloon($id)  
    {
        
        $installment = Balloon_installment::where('user_id', $id)->get();
        $user = User::find($id);

        $total_loan = Balloon::where('user_id',$id)->sum('amount');
        $total_downpayment = Balloon::where('user_id',$id)->sum('downpayment');
        $total_interest = Balloon_installment::where('user_id',$id)->where('status',1)->sum('interest');
        $late_fee = Balloon_installment::where('user_id',$id)->where('status',1)->sum('late_fee');
        $total_payment_due=Balloon_installment::where([['status','=','1'],['user_id','=',$id],])->sum('total_payment');
        $total_profit = $total_interest + $late_fee;
        $total_paid = $total_payment_due + $late_fee;

        return view('admin.authcustomer.history.complete_balloon_history', compact('installment','total_loan','total_downpayment','total_profit','total_paid','user','id'));

    }

}
