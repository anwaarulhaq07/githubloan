@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('loan summary') }}
    </div>
    <div >
        <form action="{{ route('admin.loan_paid')}}" method="post">
            @csrf
            <input type="hidden" name="id" id="" value="{{$id}}">
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
                        <td>Total: {{$t_amount}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>


                    @foreach($installment as $installment)
                    <tr>
                        <td>{{$installment->end_balance}}</td>
                        <td style="text-align: center">{{$installment->install_id}}</td>
                        <td>{{$installment->principal_dues}}</td>
                        <td>{{$installment->interest_dues}}</td>
                        <td>{{$installment->begin_balance}}</td>
                        <td>{{$installment->late_fee}}</td>

                        <td>
                            <!-- Modal -->
                            <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title w-100 font-weight-bold">Pay Installment</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{route('admin.autopaymentstore')}}" method="post">
                                            @csrf
                                            <div class="modal-body mx-3">
                                                <div class="md-form mb-5">
                                                    <label data-error="wrong" data-success="right" for="form34">Date</label>
                                                    <input type="date" name="date" id="form29" class="form-control validate" value="">
                                                </div>
                                                <div class="md-form mb-5">
                                                    <input type="hidden" name="name" id="form29" class="form-control validate" value="{{$user->name}}">
                                                </div>

                                                <div class="md-form mb-5">
                                                    <input type="hidden" name="loan_id" id="form29" class="form-control validate" value="{{$installment->loan_id}}">
                                                </div>

                                                <div class="md-form mb-5">
                                                    <label data-error="wrong" data-success="right" for="qq">Period</label>
                                                    <input type="number" name="install_id" id="qq" class="form-control validate" value="{{$installment->install_id}}">
                                                </div>


                                                <div class="md-form mb-5">
                                                    <label data-error="wrong" data-success="right" for="form32">Amount</label>
                                                    <input type="text" name="begin_balance" id="form32" class="form-control validate" value="{{$installment->begin_balance}}">
                                                </div>
                                                <div class="md-form mb-5">
                                                    <label data-error="wrong" data-success="right" for="form32">Late Fee</label>
                                                    <input type="text" name="late_fee" id="form32" class="form-control validate">
                                                </div>
                                                <div class="md-form mb-5">
                                                    <label data-error="wrong" data-success="right" for="form32">Select Bank</label>
                                                    <select name="receiver" class="form-select" aria-label="Default select example">
                                                        @foreach($banks as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}({{$item->bank_name}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button class="btn btn-success" type="submit" onclick="myFunction()">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- button -->
                            <div class="text-center">
                                @if($installment->status == '1')
                                <button class="btn btn-success" onclick="fun()">paid</button>
                                @endif
                                @if($installment->status == '0')
                                <button class="btn btn-danger" data-toggle="modal" data-target="#modalContactForm">pay</button>
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
    function myFunction() {
        alert("Are you sure!");
    }
    function fun() {
        alert("Already paid");
    }
</script>


@endsection
