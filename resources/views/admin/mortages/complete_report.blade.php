@extends('layouts.master')
@section('content')
<div class="card">
    <p class="text-center card-header"> {{ trans('Mortage Report') }} </p>
    <div class="card-header">
        <div style="float: left;">
            <p> {{ trans('Total Loan: ') }} ${{number_format((float)$total_loan,2,'.',',')}}</p>
            <p> {{ trans('Total Downpayment: ') }} ${{number_format((float)$total_downpayment,2,'.',',')}} </p>
			<p> {{ trans('Total 5 Points: ') }} ${{number_format((float)$total_5_points,2,'.',',')}} </p>
            <p> {{ trans('Total Paid: ') }} ${{number_format((float)$total_paid,2,'.',',')}} </p>
            <p> {{ trans('Total Profit: ') }} ${{number_format((float)$total_profit,2,'.',',')}}</p>
        </div>
        <div style="float: right;">
           {{-- <form action="" method="post">
                @csrf
                <label for="from_date">from:</label>
                <input type="text" name="form_date" id="from_date" value="">
                <label for="to_date">To:</label>
                <input type="text" name="to_date" id="to_date" value="">
                <button type="submit" class="btn btn-xs btn-dark mt-1 ml-3">Search</button>
            </form>--}}
            <div>
                <a href="{{route('complete_mortage_export')}}"><button class="btn btn-xs btn-dark mt-1" style="float: right; 
                    margin-right: 35px;">Print</button></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Mortage">
                <thead>
                    <tr>

                        <th>
                            {{ trans('cruds.mortage.fields.id') }}
                        </th>
                        <th>
                            {{ trans('Customer') }}
                        </th>
                        <th>
                            {{ trans('Loan Amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.downpayment') }}
                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.percentage') }}
                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.loan_terms') }}
                        </th>
                        <th>Total Paid</th>
                        <th>Total Profit</th>
                        <th>
                            {{ trans('cruds.mortage.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('Report') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mortages as $mortage)
                    <tr>

                        <td>
                            {{ $mortage->id }}
                        </td>
                        <td>
                            {{ $mortage->user->name }}
                        </td>
                        <td>
                        ${{number_format((float)$mortage->loandamoutn,2,'.',',')}}
                        </td>
                        <td>
                        ${{number_format((float)$mortage->downpayment,2,'.',',')}}
                        </td>
                        <td>
                            {{ $mortage->percentage }}%
                        </td>
                        <td>
                            {{ $mortage->loan_terms }}
                        </td>
                        <td>${{number_format((float)$mortage->total_paid,2,'.',',')}}</td>
                        <td>${{number_format((float)$mortage->total_profit,2,'.',',')}}</td>

                        <td>
                            {{ $mortage->start_date}}
                        </td>
                        <td>
                            <a href="{{url('admin/report/'.$mortage->id)}}"><button
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