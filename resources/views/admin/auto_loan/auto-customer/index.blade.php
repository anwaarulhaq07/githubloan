@extends('layouts.master') @section('content')

<div class="card">
    <div class="card-header">
        {{ trans("Auto Loan Customer") }}
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
                    @foreach($loan as $data)

                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->amount}}</td>
                        <td>{{$data->payments->max('month_id')+1}}</td>
                        <td>{{ $data->amount - $data->payments->sum('payment')}}</td>
                        <td>
                            <form action="{{ route('admin.loanlist')}}" method="get">
                                <input type="hidden" name="id" id="" value="{{ $data->id ?? '' }}">
                                <button type="submit" class="btn btn-xs btn-dark">summary</button>
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