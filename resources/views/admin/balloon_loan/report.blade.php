@extends('layouts.master')
@section('content')
@can('mortage_create')
@endcan
<!-- loan summary  -->

<div class="card">
    <div class="card-header text-center">
        {{ trans('Report Card') }}
    </div>
    <div>
            <a href="{{url('export/'.$balloon->id)}}"><button class="btn btn-xs btn-dark mt-1" style="float: right; 
            margin-right: 35px;">Print</button></a>
    </div>
    <div class="ml-3">
        {{ trans(' Name: ') }} {{$balloon->user->name}}
    </div>
	<div class="ml-3">
        {{ trans('Property Address: ') }} {{$balloon->property_address}} 
    </div>
    <div class="ml-3">
        {{ trans(' Loan: ') }} ${{number_format ( $balloon->amount, 2, ".", "," )}}
    </div>
    <div class="ml-3">
        {{ trans(' Down Payment: ') }} ${{number_format ( $balloon->downpayment, 2, ".", "," )}}
    </div>
	<div class="ml-3">
        {{ trans('5 Points: ') }} ${{number_format ( $balloon->extra_fee, 2, ".", "," )}}
    </div>
    <div class="ml-3">
        {{ trans(' Total Paid: ') }} ${{number_format ( $total_paid, 2, ".", "," )}}
    </div>
    <div class="ml-3">
        {{ trans(' Profit: ') }} ${{number_format ( $total_profit, 2, ".", "," )}}
    </div>
    <div class="card-body">
        <div class="table-responsive"> 


            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Balance</th>
                        <th scope="col">Month/Duration</th>
                        <th scope="col">Principal</th>
                        <th scope="col">Interest</th>
                        <th scope="col">Installment</th>
                        <th scope="col">Late Fee</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td>Total: ${{number_format((float)$t_amount,2,'.',',')}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @foreach($installment as $installment)
                    <tr>
                        <td>${{number_format((float)$installment->balance,2,'.',',')}}</td>
                        <td style="text-align: center">{{$installment->install_id}}</td>
                        <td>${{number_format((float)$installment->principal,2,'.',',')}}</td>
                        <td>${{number_format((float)$installment->interest,2,'.',',')}}</td>
                        <td>${{number_format((float)$installment->total_payment,2,'.',',')}}</td>
                        <td>${{number_format((float)$installment->late_fee,2,'.',',')}}</td>

                        <td>
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