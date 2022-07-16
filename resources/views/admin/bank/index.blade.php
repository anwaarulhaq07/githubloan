@extends('layouts.master')
@section('content')
@can('mortage_create') 
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.bank_create') }}">
            {{ trans('Add Bank') }}
        </a>
        <a class="btn btn-warning" style="float: right;" href="{{ route('admin.complete_trans_history') }}">
            {{ trans('History') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('Bank Detail') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Mortage">
                <thead>
                    <tr>
                        <th>ID</th> 
                        <th>Account title</th>
                        <th>Bank Name</th>
                        <th>Total Balance</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bank as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->Account_title}}</td>
                        <td>{{$data->bank_name}}</td>
                        <td>${{number_format ( $data->total_balance, 2, ".", "," ) ?? ''}}</td>
                        <td>
                            <a href="{{url('admin/transaction/'.$data->id)}}" type="button" class="btn btn-xs btn-success">Credit</a>
                            <a href="{{url('admin/send_balance/'.$data->id)}}" type="button" class="btn btn-xs btn-success">Debit</a>
                            <a href="{{url('admin/trans_history/'.$data->id)}}" type="button" class="btn btn-xs btn-warning">History</a>
                            <a href="{{url('admin/bank_destroy/'.$data->id)}}" type="button" class="btn btn-xs btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>


            </table>
        </div>
    </div>
</div>

@endsection
