@extends('layouts.master')
@section('content')
<!-- Modal -->
<div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Pay Installment</h4>
            </div>
            <form action="{{route('admin.balloonpaymentstore')}}" method="post"> 
                @csrf
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="form34">Date</label>
                        <input type="date" name="date" id="form29" class="form-control validate" value=""> 
                    </div>
                    <div class="md-form mb-5">
                        <input type="hidden" name="name" id="form29" class="form-control validate"
                            value="{{$user->name}}">
                    </div>

                    <div class="md-form mb-5">
                        <input type="hidden" name="parent_id" id="parent_id" class="form-control validate"
                            value="{{$installment->parent_id}}">
                    </div>
                    <div class="md-form mb-5">
                        <input type="hidden" name="loan_id" id="form29" class="form-control validate"
                            value="{{$installment->balloon_id}}">
                    </div>
                    <div class="md-form mb-5">
                        <input type="hidden" name="type_id" id="form29" class="form-control validate"
                            value="{{$installment->type}}"> 
                    </div>

                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="qq">Period</label>
                        <input type="number" name="install_id" id="qq" class="form-control validate"
                            value="{{$install_id}}">
                    </div>


                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="form32">Amount</label>
                        <input type="text" name="payment" id="form32" class="form-control validate"
                            value="{{$installment->total_payment}}">
                    </div>
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="form32">Late Fee</label>
                        <input type="text" name="late_fee" id="form32" class="form-control validate">
                    </div>
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="note">Notes</label>
                        <input type="text" name="note" id="note" class="form-control validate">
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
                    <button class="btn btn-success" type="submit" onclick="myFunction()">Send <i
                            class="fas fa-paper-plane-o ml-1"></i></button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- button -->
 {{--<div class="text-center">
    @if($installment->status == '1')
    <button class="btn btn-success" onclick="fun()">paid</button>
    @endif
    @if($installment->status == '0')
    <form action="{{url('install_pay/'.$installment->install_id)}}" method="get">
        @csrf
        <input type="hidden" name="user_id" id="" value="{{$user->id ?? '' }}">
        <button type="submit" class="btn btn-danger">pay</button>
    </form>
    @endif

</div>--}}

<!-- Modal end -->
<script>
    function myFunction() {
        alert("Are you sure!");
    }
    function fun() {
        alert("Already paid");
    }
</script>


@endsection