@extends('layouts.master')
@section('content')

<div class="card">
    <p class="card-header text-center"> {{ trans('Transaction History') }} </p>
    <div class="card-header">
        <div style="float: left;">
            <p> {{ trans('Bank Name: ') }}{{$bank->bank_name}}</p>
            
            
            <p> {{ trans('Total Deposit: ') }} ${{number_format ( $total_amount, 2, ".", "," ) ?? ''}}</p>
			<p> {{ trans('Total 5 Points: ') }} ${{number_format ( $total_5_points, 2, ".", "," ) ?? ''}}</p>
            <p> {{ trans('Total Profit: ') }} ${{number_format ( $total_profit, 2, ".", "," ) ?? ''}}</p>
        </div>
        <div style="float: right;">
            <form action="{{route('admin.bank_limit_history')}}" method="post">
                @csrf
                <input type="hidden" name="bank_id" id="" value="{{$id}}">
                <label for="from_date">from:</label>
                <input type="date" name="from_date" id="from_date" value="">
                <label for="to_date">To:</label>
                <input type="date" name="to_date" id="to_date" value="">
                <button type="submit" class="btn btn-xs btn-dark mt-1 ml-3">Search</button>
            </form>
            <div style="float: right; margine-top: 9px;">
                <form action="{{route('bank_history_excel')}}" method="post">
                    @csrf
                    <input type="hidden" name="bank_id" id="" value="{{$id}}">
                    <input type="hidden" name="from_date" id="from_date" value="{{$from_date ?? '' }}">
                    <input type="hidden" name="to_date" id="to_date" value="{{$to_date ?? ''}}">
                    <button class="btn btn-xs btn-dark mt-1" style="float: right;
                            margin-right: 35px;">Print</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Mortage">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Purpose of Transaction</th>
                            <th>Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->from}}</td>
                            <td>${{number_format ( $data->amount, 2, ".", "," ) ?? ''}}</td>
                            <td>{{$data->status}}</td>
                            <td>{{$data->purpose}}</td>
                            <td>{{$data->date}}</td>

                        </tr>
                        @endforeach

                    </tbody>


                </table>
            </div>
        </div>
    </div>

    @endsection