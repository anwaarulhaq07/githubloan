<table class="table">
    <thead>
         <tr>
            <td>Total Loan: </td>
            <td>${{number_format((float)$total_loan,2,'.',',')}}</td>
        </tr>
        <tr>
            <td>Total Downpayment:</td>
            <td>${{number_format((float)$total_downpayment,2,'.',',')}}</td>
        </tr>
        <tr>
            <td>Total 5 Points:</td>
            <td>${{number_format((float)$total_5_points,2,'.',',')}}</td>
        </tr>
        <tr>
            <td>Total Paid: </td>
            <td>${{number_format((float)$total_paid,2,'.',',')}}</td>
        </tr>
        <tr>
            <td>Total Profit: </td>
            <td>${{number_format((float)$total_profit,2,'.',',')}}</td>
        </tr>
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
        </tr>
    </thead>
    <tbody>
        @foreach($mortages as $key => $mortage)
        <tr>
            <td>
                {{ $mortage->id ?? '' }}
            </td>
            <td>
                {{ $mortage->user->name ?? '' }}
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
                {{ $mortage->start_date ?? '' }}
            </td>

        </tr>
        @endforeach
    </tbody>
</table>