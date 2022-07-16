@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('loan summary') }}
    </div>
    <div>
        <form action="{{ route('admin.balloon_paid_installment')}}" method="post"> 
            @csrf
            <input type="hidden" name="id" id="" value="{{$id}}">
            <button type="submit" class="btn btn-xs btn-dark mt-1" style="float: right; 
            margin-right: 35px;">Paid Installment</button>
        </form>
    </div>

    <div class="card-body">
        <div class="table-responsive"> 


            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Balance</th>
                        <th scope="col">Month/Duration</th>
                        <th scope="col">Principal</th>
                        <th scope="col">Interest</th>
                        <th scope="col">Installment</th>
                        <th scope="col">Late Fee</th>
                        <th scope="col">Operation</th>
                    </tr>
                </thead>

                <tbody>
                    <tr> 
                        <td>Total: ${{number_format((float)$t_amount,2,'.','')}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr> 
                        <td>Actual number of payments: {{$actual_num_amount}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @foreach($installment as $installment) 
                    <tr>
                        <td>${{number_format((float)$installment->balance,2,'.','')}}</td>
                        <td style="text-align: center">{{$installment->install_id}}</td>
                        <td>${{number_format((float)$installment->principal,2,'.','')}}</td>
                        <td>${{number_format((float)$installment->interest,2,'.','')}}</td>
                        <td>${{number_format((float)$installment->total_payment,2,'.','')}}</td>
                        <td>${{number_format((float)$installment->late_fee,2,'.','')}}</td>
                        <td>
                            <!-- button -->
                            <div class="text-center">
                                @if($installment->status == '1')
                                 <div class="btn-group">
                                    <button type="button" class="btn btn-success"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        paid
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item btn btn-warning" href="#">{{$installment->note}}</a></li>
                                    </ul>
                                </div>
                                @endif
                                @if($installment->status == '0')
                                 <form action="{{url('install_pay/'.$installment->install_id)}}" method="get">
                                        @csrf
                                        <input type="hidden" name="balloon_id" id="" value="{{$installment->balloon_id}}">
                                        <input type="hidden" name="parent_id" id="" value="{{$user->parent_id}}">
                                        <input type="hidden" name="user_id" id="" value="{{$user->id}}">
                                        <input type="hidden" name="type" id="" value="{{$installment->type}}">
                                        <input type="hidden" name="interest" id="" value="{{$installment->interest}}">
                                        <button type="submit" class="btn btn-danger">pay</button>
                                    </form>
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
<script>
    function myFunction() {
        alert("Are you sure!");
    }
    function fun() {
        alert("Already paid");
    }
</script>


@endsection
