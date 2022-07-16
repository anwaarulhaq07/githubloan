<table class="table">
    <thead>
        <tr>
            <td>Name: </td>
            <td>{{$balloon->user->name}}</td>
        </tr>
		<tr>
            <td>Property Address: </td>
            <td>{{$balloon->property_address}}</td>
        </tr>
        <tr>
            <td>Loan: </td>
            <td>${{number_format ( $balloon->amount, 2, ".", "," )}}</td>
        </tr>
        <tr>
            <td>Down Payment: </td>
            <td>${{number_format ( $balloon->downpayment, 2, ".", "," )}}</td> 
        </tr>
        <tr>
            <td>5 Points: </td>
            <td>${{number_format ( $balloon->extra_fee, 2, ".", "," )}}</td>
        </tr>
        <tr>
            <td>Total Paid: </td>
            <td>${{number_format ( $total_paid, 2, ".", "," )}}</td>
        </tr>
        <tr>
            <td>Profit: </td>
            <td>${{number_format ( $total_profit, 2, ".", "," )}}</td>
        </tr>
        <tr>
            <th scope="col">Balance</th>
            <th scope="col">Month/Duration</th>
            <th scope="col">Principal</th>
            <th scope="col">Interest</th>
            <th scope="col">Installment</th>
            <th scope="col">Late Fee</th>
            <th scope="col">Status</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>Total: ${{number_format((float)$t_amount,2,'.',',')}}</td>
        </tr>

        @foreach($installment as $installment)
        <tr>
            <td>${{number_format((float)$installment->balance,2,'.',',')}}</td>
            <td style="text-align: center">{{$installment->install_id}}</td>
            <td>${{number_format((float)$installment->principal,2,'.',',')}}</td>
            <td>${{number_format((float)$installment->interest,2,'.',',')}}</td>
            <td>${{number_format((float)$installment->total_payment,2,'.',',')}}</td>
            <td>${{number_format((float)$installment->late_fee,2,'.',',')}}</td>

            <td>
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