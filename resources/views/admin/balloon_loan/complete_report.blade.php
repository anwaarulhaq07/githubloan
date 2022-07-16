@extends('layouts.master')
@section('content')
<div class="card">
    <p class="text-center card-header"> {{ trans('Commercial Loan Report') }} </p>
    <div class="card-header">
        <div style="float: left;">
            <p> {{ trans('Total Loan: ') }} ${{number_format((float)$loan_amount,2,'.',',')}}</p>
            <p> {{ trans('Total Downpayment: ') }} ${{number_format((float)$downpayment,2,'.',',')}} </p>
			<p> {{ trans('Total 5 Points: ') }} ${{number_format((float)$total_5_points,2,'.',',')}} </p>
            <p> {{ trans('Total Paid: ') }} ${{number_format((float)$total_paid,2,'.',',')}} </p>
            <p> {{ trans('Total Profit: ') }} ${{number_format((float)$total_profit,2,'.',',')}}</p>
        </div>
        <div style="float: right;">
            {{--<form action="" method="post">
                @csrf
                <label for="from_date">from:</label>
                <input type="text" name="form_date" id="from_date" value="">
                <label for="to_date">To:</label>
                <input type="text" name="to_date" id="to_date" value="">
                <button type="submit" class="btn btn-xs btn-dark mt-1 ml-3">Search</button>
            </form>--}}
            <div>
            <a href="{{route('complete_export')}}"><button class="btn btn-xs btn-dark mt-1" style="float: right; 
                    margin-right: 35px;">Print</button></a>
        </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Mortage">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Loan Amount</th>
                        <th>Down Payment</th>
                        <th>Percentage</th>
                        <th>Balloon Period</th>
                        <th>Terms</th>
                        <th>Total Paid</th>
                        <th>Total Profit</th>
                        <th>Start date</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($balloon as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->user->name}}</td>
                        <td>${{number_format((float)$data->amount,2,'.',',')}}</td>
                        <td>${{number_format((float)$data->downpayment,2,'.',',')}}</td>
                        <td>{{$data->percentage}}&nbsp%</td>
                        <td>{{$data->balloon_period}}&nbspyear</td>
                        <td>{{$data->loan_terms}}&nbspyear</td>
                        <td>${{number_format((float)$data->total_paid,2,'.',',')}}</td>
                        <td>${{number_format((float)$data->total_profit,2,'.',',')}}</td>
                        <td>{{$data->starttime}}</td>
                        <td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection