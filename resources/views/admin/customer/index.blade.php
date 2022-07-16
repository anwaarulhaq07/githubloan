@extends('layouts.master')
@section('content')
<!-- <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-xs btn-success" href="{{ route('admin.mortages.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.mortage.title_singular') }}
            </a>
        </div>
    </div> -->

<div class="card">
    <div class="card-header">
       {{ trans("Mortgage Customer") }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table" style="text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Total Loan</th>
                        <th scope="col">Next Installment</th>
                        <th scope="col">Remaining Dues</th>
                        <th scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mortages as $data) 

                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->loandamoutn}}</td>
                        <td>{{$data->payments->max('month_id')+1}}</td>
                        <td>{{ $data->loandamoutn - $data->payments->sum('payment')}}</td>
                        <td>
                            <form action="{{ route('admin.summary')}}" method="get">
                                <input type="hidden" name="id" id="" value="{{ $data->id ?? '' }}">
                                <button type="submit" class="btn btn-xs btn-success">Summary</button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection