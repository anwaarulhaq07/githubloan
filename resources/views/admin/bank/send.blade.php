@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('Share Balance') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.share_balance') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="" value="{{ $bank->id }}">
                <div class="form-group">
                    <label class="" for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $bank->name }}" readonly>
                </div>
                <div class="form-group">
                    <label class="" for="bank_name">Bank Name</label>
                    <input type="text" class="form-control" name="bank_name" id="bank_name" value="{{ $bank->bank_name }}"
                        readonly>
                </div>
                <div class="form-group">
                    <label class="" for="current_balance">{{ trans('My Balance') }}</label>
                    <input class="form-control" type="number" name="current_balance" id="current_balance"
                        value="{{ $bank->total_balance }}" readonly>
                </div>
                <div class="form-group">
                    <label class="" for="add_balance">{{ trans('To') }}</label>
                    <select name="receiver" class="form-select" aria-label="Default select example">
                        @foreach ($banks as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="" for="add_balance">{{ trans('Purpose of Transaction') }}</label>
                    <select name="purpose" class="form-select" aria-label="Default select example">
                        <option >Supplier/Distributer Pament</option>
                        <option >Medical Payment</option>
                        <option >Online Purchase</option>
                        <option >School/University Fee Patment</option>
                        <option >Hotel Payment</option>
                        <option >E-Ticket Payment</option>
                        <option >Rental Payment</option>
                        <option >Club/Service Fee</option>
                        <option >Mutual Funds</option>
                        <option >Personal Loan Payment</option>
                        <option >Credit Card Bill Payment</option>
                        <option >Zakat payment To Individual</option>
                        <option >Wallet Payment</option>
                        <option >Local Transfer RDA</option>
                        <option >Tax Payment</option>
                        <option selected >Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="required" for="share_balance">{{ trans('Amount') }}</label>
                    <input class="form-control " type="number" value="" name="shared_balance" id="share_balance" required>

                </div>


                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('Send') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
