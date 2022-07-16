@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('Edit') }}
    </div>

    <div class="card-body">
        <form method="post" action="{{url('admin/loanUpdate')}}" enctype="multipart/form-data">
            @method('post')
            @csrf

            <div class="form-group">
                <input type="hidden" name="id" id="" value="{{$loan->id}}">
            </div>
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('Customer') }}</label>
                <select name="user_id" class="form-select" aria-label="Default select example">
                    @foreach($user as $item)
                    <option >{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="required" for="loandamoutn">{{ trans('Loan Amount') }}</label>
                <input class="form-control {{ $errors->has('loandamoutn') ? 'is-invalid' : '' }}" type="number" name="amount" id="loandamoutn" value="{{$loan->amount}}" required>
            </div>
            <div class="form-group">
                <label class="required" for="downpayment">{{ trans('cruds.mortage.fields.downpayment') }}</label>
                <input class="form-control {{ $errors->has('downpayment') ? 'is-invalid' : '' }}" type="number" name="downpayment" id="downpayment" value="{{$loan->downpayment}}"   required>

            </div>
            <div class="form-group">
                <label class="required" for="percentage">{{ trans('Interest rate') }}</label>
                <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="number" name="percentage" id="percentage" value="{{$loan->percentage}}"  required>

            </div>

            <div class="form-group">
                <label class="required">{{ trans('cruds.mortage.fields.loan_terms') }}</label>
                <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="number" name="loan_terms" id="loan_terms" value="{{$loan->loan_terms}}" required placeholder="in year">

            </div>

            <div class="form-group">
                <label class="required" for="start_date">{{ trans('Start date') }}</label>
                <input class="form-control" type="text" name="starttime" id="start_date" value="{{$loan->starttime}}" placeholder="00/00/0000" required>

            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection