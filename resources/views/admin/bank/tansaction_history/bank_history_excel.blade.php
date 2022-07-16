
<table>
    <tr>
        <td>Transaction History</td>
        <td></td>
    </tr>
    <tr>
        <td>Bank Name:</td>
        <td>{{$bank->bank_name}}</td>
    </tr>
    <tr>
        <td>Total Deposit: </td>
        <td>${{number_format ( $total_amount, 2, ".", "," ) ?? ''}}</td>
    </tr>
	 <tr>
        <td>Total 5 Point: </td>
        <td>${{number_format ( $total_5_points, 2, ".", "," ) ?? ''}}</td>
    </tr>
    <tr>
        <td>Total Profit:</td>
        <td>${{number_format ( $total_profit, 2, ".", "," ) ?? ''}}</td>
    </tr>

    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Purpose of Transaction</th>
            <th>Date</th>

        </tr>
    </thead>
    <tbody>
        @foreach($history as $data)
        <tr>
            <td>{{$data->id}}</td>
            <td>{{$data->from}}</td>
            <td>${{number_format ( $data->amount, 2, ".", "," ) ?? ''}}</td>
            <td>{{$data->status}}</td>
            <td>{{$data->purpose}}</td>
            <td>{{$data->date}}</td>

        </tr>
        @endforeach

    </tbody>


</table>