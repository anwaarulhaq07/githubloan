@extends('layouts.master')
@section('content')
@can('mortage_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.loancreate') }}">
            {{ trans('Add Loan') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('Auto Loan') }}
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
                        <th>Terms</th>
                        <th>Start date</th>
                        <th>Operation</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($auto_loan as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->user->name}}</td>
                        <td>{{$data->amount}}</td>
                        <td>{{$data->downpayment}}</td>
                        <td>{{$data->percentage}}</td>
                        <td>{{$data->loan_terms}}&nbspyear</td>
                        <td>{{$data->starttime}}</td>
                        <td>
                            <div style="display: flex;">
                                <di>
                                    <!-- <a href="{{url('admin/edit/'.$data->id)}}" type="button" class="btn btn-xs btn-success">Edit</a> -->
                                    <a href="{{url('admin/delete/'.$data->id)}}" type="button" class="btn btn-xs btn-danger">Delete</a>
                                </di>
                                <di>
                                    <form action="{{ route('admin.loanlist')}}" method="get">
                                        @csrf
                                        <input type="hidden" name="id" id="" value="{{$data->id ?? '' }}">
                                        <button type="submit" class="btn btn-xs btn-dark mt-1 ml-3">Summary</button>
                                    </form>
                                </di>
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