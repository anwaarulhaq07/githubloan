@extends('layouts.master')
@section('content')
@can('balloon_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.balloon_create') }}">
            {{ trans('Add Loan') }}
        </a>
        <a style="float: right;" class="btn btn-success" href="{{ route('admin.balloon_complete_report') }}">
            {{ trans('Report') }}
        </a>
    </div>
</div>
<div  class="row"> 
    <div class="col-lg-12">
        
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('Commercial Loan') }}
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
                        <th>Start date</th>
                        <th>Operation</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($balloon as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->user->name}}</td>
                        <td>${{number_format ( $data->amount, 2, ".", "," )}}</td>
                        <td>${{number_format ( $data->downpayment, 2, ".", "," )}}</td>
                        <td>{{$data->percentage}}%</td>
                        <td>{{$data->balloon_period}}&nbspyear</td>
                        <td>{{$data->loan_terms}}&nbspyear</td>
                        <td>{{$data->starttime}}</td> 
                        <td>
                            <div style="display: flex;">
                            @can('balloon_delete')
                                    <a href="{{url('admin/balloon_delete/'.$data->id)}}" type="button" class="btn btn-xs btn-danger mt-1">Delete</a>
                                @endcan
                                    <a href="{{ route('admin.balloon_summary',[$data->id])}}"><button type="submit" class="btn btn-xs btn-dark mt-1 mx-1">Summary</button></a>
                                
                                <a href="report_balloon/{{$data->id}}"><button  class="btn btn-xs btn-warning mt-1 " >Report</button></a>
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
