@extends('layouts.master')
@section('content')
@can('mortage_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a style="float: right;" class="btn btn-warning" href="{{ route('admin.complete_balloon_history',[$id]) }}">
            {{ trans('History') }}
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">

    </div>
</div>
@endcan
<div class="card">
    <p class="text-center card-header"> {{ trans('Balloon History') }} </p>
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
                        <th>Start date</th>
                        <th>Operation</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($balloon as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->user->name}}</td> 
                        <td>${{number_format ( $data->amount, 2, ".", "," ) ?? ''}}</td>
                        <td>${{number_format ( $data->downpayment, 2, ".", "," ) ?? ''}}</td>
                        <td>{{$data->percentage}}%</td>
                        <td>{{$data->balloon_period}}&nbspyear</td>
                        <td>{{$data->loan_terms}}&nbspyear</td>
                        <td>{{$data->starttime}}</td>
                        <td>

                            <a href="{{route('admin.report_balloon',[$data->id])}}"><button
                                    class="btn btn-xs btn-dark mt-1 ">Report</button></a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection