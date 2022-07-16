<table class="table">
    <thead>
        <tr><td>Commercial Loan Report</td></tr>
        <tr>
            <td>Total Loan: </td>
            <td>${{number_format((float)$loan_amount,2,'.',',')}}</td> 
        </tr>
        <tr>
            <td>Total Downpayment:</td>
            <td>${{number_format((float)$downpayment,2,'.',',')}}</td> 
        </tr>
		<tr>
            <td>Total 5 Points:</td>
            <td>${{number_format((float)$total_5_points,2,'.',',')}}</td>  
        </tr>
        <tr>
            <td>Total Paid:</td>
            <td>${{number_format((float)$total_paid,2,'.',',')}}</td>  
        </tr>
        <tr>
            <td>Total Profit: </td>
            <td>${{number_format((float)$total_profit,2,'.',',')}}</td> 
        </tr>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Loan Amount</th>
            <th>Down Payment</th>
            <th>Percentage</th>
            <th>Balloon Period</th>
            <th>Terms</th>
            <th>Total Paid</th>
            <th>Total Profit</th>
            <th>Start date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($balloon as $balloon)
        <tr>
            <td>{{$balloon->id}}</td>
            <td>{{$balloon->user->name}}</td>
            <td>${{number_format((float)$balloon->amount,2,'.',',')}}</td>
            <td>${{number_format((float)$balloon->downpayment,2,'.',',')}}</td>
            <td>{{$balloon->percentage}}%</td>
            <td>{{$balloon->balloon_period}} year</td>
            <td>{{$balloon->loan_terms}} year</td>
            <td>${{number_format((float)$balloon->total_paid,2,'.',',')}}</td>
            <td>${{number_format((float)$balloon->total_profit,2,'.',',')}}</td>
            <td>{{$balloon->starttime}}</td>
        </tr>
        @endforeach
    </tbody>
</table>