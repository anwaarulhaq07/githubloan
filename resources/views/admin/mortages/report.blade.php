@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header text-center">
        {{ trans('Report Card') }} 
    </div>
    <div>
            <a href="{{url('mortage_export/'.$mortage->id)}}"><button class="btn btn-xs btn-dark mt-1" style="float: right; 
            margin-right: 35px;">Print</button></a>
    </div>
    <div class="ml-3">
     {{ trans(' Name: ') }} {{$mortage->user->name}}
    </div>
	 <div class="ml-3">
     {{ trans(' Property Address: ') }} {{$mortage->property_address}}
    </div>
    <div class="ml-3">
        {{ trans(' Loan: ') }} ${{number_format((float)$mortage->loandamoutn,2,'.',',')}}
    </div>
    <div class="ml-3">
        {{ trans(' Down Payment: ') }} ${{number_format((float)$mortage->downpayment,2,'.',',')}}
    </div>
	<div class="ml-3">
        {{ trans(' 5 Points: ') }} ${{number_format((float)$mortage->extra_fee,2,'.',',')}}
    </div>
    <div class="ml-3">
        {{ trans(' Total Paid: ') }} ${{number_format((float)$total_paid,2,'.',',')}}
    </div>
    <div class="ml-3">
        {{ trans(' Profit: ') }} ${{number_format((float)$total_profit,2,'.',',')}}
    </div>
    <div class="ml-3">
        {{ trans(' Total Interest: ') }} ${{number_format((float)$total_interest,2,'.',',')}}
    </div>
    <div class="card-body">
        <div class="table-responsive">


            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Principal Balance</th>
                        <th scope="col">Month/Duration</th>
                        <th scope="col">Principal Dues</th>
                        <th scope="col">Interest Due</th>
                        <th scope="col">Cumulative Interest</th>
                        <th scope="col">Payment Due</th>
                        <th scope="col">Late Fee</th>
                        <th scope="col">Status</th>

                    </tr>
                </thead>
                @php 
                    $previous_intrest = 0;
                @endphp
                <tbody>
                    @foreach($installment as $installment)
                    <tr>
                        
                    <td>${{number_format((float)$installment->balance,2,'.',',')}}</td>
                    <td>{{$installment->install_id}}</td>
                    <td>${{number_format((float)$installment->principal_dues,2,'.',',')}}</td>
                    <td>${{number_format((float)$installment->interest_dues,2,'.',',')}}</td>
                    @php
                    $previous_intrest =  $installment->interest_dues + $previous_intrest;
                    @endphp
                    <td>${{number_format((float)$previous_intrest,2,'.',',')}}</td>
                    <td>${{number_format((float)$installment->payment_dues,2,'.',',')}}</td>
                    <td>${{number_format((float)$installment->late_fee,2,'.',',')}}</td>
                        <td>
                            <!-- button -->
                            <div class="text-center">
                                @if($installment->status == '1')
                                <h6 class="text-success">Paid</h6>
                                @endif
                                @if($installment->status == '0')
                                <p class="text-black-50">Pending</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
