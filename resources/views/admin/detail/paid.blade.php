@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
 {{ trans(' paid Installment') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">


            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Month</th>
                        <th scope="col">Payment</th>
                        <th scope="col">Late Fee</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($payment as $data)
                    <tr>
                        <td>{{$data->install_id}}</td>
                        <td>{{$data->payment}}</td>
                        <td>{{$data->late_fee}}</td>
                        <td>{{$data->date}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
