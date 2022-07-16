@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header text-center">
        {{ trans('Report Card') }}
    </div>
    <div>
        <div class="card-header">
            <div style="float: left;">
                <p>{{ trans(' Name: ') }} {{$user->name}}</p> 
                <p>{{ trans(' Loan: ') }} ${{number_format ( $total_loan, 2, ".", "," ) ?? ''}}</p>
                <p>{{ trans(' Down Payment: ') }} ${{number_format ( $total_downpayment, 2, ".", "," ) ?? ''}}</p>
                <p>{{ trans(' Total Paid: ') }} ${{number_format ( $total_paid, 2, ".", "," ) ?? ''}}</p>
                <p>{{ trans(' Profit: ') }} ${{number_format ( $total_profit, 2, ".", "," ) ?? ''}}</p>
            </div>
            {{-- <div style="float: right;">
                <form action="" method="post">
                    @csrf
                    <label for="from_date">from:</label>
                    <input type="date" name="from_date" id="from_date" value="">
                    <label for="to_date">To:</label>
                    <input type="date" name="to_date" id="to_date" value="">
                    <button type="submit" class="btn btn-xs btn-dark mt-1 ml-3">Search</button>
                </form>
            </div>--}}
        </div>
        <a href=""><button class="btn btn-xs btn-dark mt-1" style="float: right; 
            margin-right: 35px;">Print</button></a>
    </div>
    <div class="card-body">
        <div class="table-responsive">


            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Principal Balance</th>
                        <th scope="col">Month/Duration</th>
                        <th scope="col">Principal Dues</th>
                        <th scope="col">Computed Interest Due</th>
                        <th scope="col">Total Payment Due</th>
                        <th scope="col">Late Fee</th>
                        <th scope="col">Status</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($installment as $installment)
                    <tr>
                        <td>${{number_format((float)$installment->balance,2,'.',',')}}</td>
                        <td>{{$installment->install_id}}</td>
                        <td>${{number_format((float)$installment->principal_dues,2,'.',',')}}</td>
                        <td>${{number_format((float)$installment->interest_dues,2,'.',',')}}</td>
                        <td>${{number_format((float)$installment->payment_dues,2,'.',',')}}</td>
                        <td>${{number_format((float)$installment->late_fee,2,'.',',')}}</td>
                        <td>
                            <!-- button -->
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