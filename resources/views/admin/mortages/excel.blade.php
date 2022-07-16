<table class="table">
    <thead>
        <tr>
            <td>Name: </td>
            <td>{{$mortage->user->name}} </td>
        </tr>
		 <tr>
            <td>Property Address: </td>
            <td>{{$mortage->property_address}} </td>
        </tr>
        <tr>
            <td>Mortage Loan: </td>
            <td>${{number_format((float)$mortage->loandamoutn,2,'.',',')}}</td>
        </tr>
        <tr>
            <td>Down Payment: </td>
            <td>${{number_format((float)$mortage->downpayment,2,'.',',')}}</td>
        </tr>
		<tr>
            <td>5 Points: </td>
            <td>${{number_format((float)$mortage->extra_fee,2,'.',',')}}</td>
        </tr>
		 <tr>
            <td>total_paid: </td>
            <td>${{number_format((float)$total_paid,2,'.',',')}}</td>
        </tr>
        <tr>
            <td>Profit: </td>
            <td>${{number_format((float)$interest,2,'.',',')}}</td>
        </tr>
        <tr>
            <td>Total Interest: </td>
            <td>${{number_format((float)$total_interest,2,'.',',')}} </td>
        </tr>
        <tr>
            <th scope="col">Principal Balance</th>
            <th scope="col">Month/Duration</th>
            <th scope="col">Principal Dues</th>
            <th scope="col">Interest Due</th>
            <th scope="col">Cumulative Interest</th>
            <th scope="col">Payment Due</th>
            <th scope="col">Late Fee</th>
            <th scope="col">Operation</th>

        </tr>
    </thead>
    @php
    $previous_intrest = 0;
    @endphp

    <tbody>
        @foreach($installment as $installment)
        <tr>
           <td>${{number_format((float)$installment->balance,2,'.',',')}}</td>
            <td>{{$installment->install_id}}</td>
            <td>${{number_format((float)$installment->principal_dues,2,'.',',')}}</td>
            <td>${{number_format((float)$installment->interest_dues,2,'.',',')}}</td>
			@php
			$previous_intrest =  $installment->interest_dues + $previous_intrest;
			@endphp
            <td>${{number_format((float)$previous_intrest,2,'.',',')}}</td>
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