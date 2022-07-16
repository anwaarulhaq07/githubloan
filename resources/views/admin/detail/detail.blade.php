@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.mortage.title_singular') }} {{ trans('summary') }} 
    </div>
    <div >
        <form action="{{ route('admin.paid')}}" method="post">
            @csrf
            <input type="hidden" name="id" id="" value="{{$install_id}}">
            <button type="submit" class="btn btn-xs btn-dark mt-1" style="float: right;
            margin-right: 35px;
        }">Paid Installment</button>
        </form>
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
                        <th scope="col">Operation</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($mortage as $mortage)
                    <tr>
                        <td>Total: ${{number_format((float)$mortage->loandamoutn,2,'.',',')}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Actual Number of amount: {{$actual_num_amount}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach

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
                                <form action="{{url('mortage_pay/'.$installment->install_id)}}" method="get">
                                        @csrf
                                        <input type="hidden" name="mortage_id" id="" value="{{$installment->mortage_id}}">
                                        <input type="hidden" name="user_id" id="" value="{{$user->id}}">
                                        <input type="hidden" name="parent_id" id="" value="{{$user->parent_id}}">
                                        <input type="hidden" name="interest_dues" id="" value="{{$installment->interest_dues}}">
                                        <button type="submit" class="btn btn-danger">pay</button>
                                    </form>
                                @endif
                            </div>
                            <!-- Modal end -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function fun() {
        alert("Already paid");
    }function fun() {
        alert("Already paid");
    }
</script>

@endsection
