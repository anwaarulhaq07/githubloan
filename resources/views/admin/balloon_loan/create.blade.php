@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('Add Customer') }}
    </div>

    <div class="card-body"> 
        <form method="POST" action="{{route('admin.balloonstore')}}" enctype="multipart/form-data"> 
            @csrf
            <div class="form-group">
                @foreach($user as $users)
                <input class="form-control" type="hidden" name="parent_id" id="parent_id" value="{{$users->parent_id}}" required>
                @endforeach
            </div>
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('Customer') }}</label>
                <select name="user_id" class="form-select" aria-label="Default select example">
                    <option value="select">Please Select</option>
                    @foreach($user as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('Loan Amount') }}</label>
                <input step="any" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number"
                    name="amount" id="loandamoutn" value="{{ old('loandamoutn', '') }}" required>
            </div>
            <div class="form-group">
                <label class="required" for="downpayment">{{ trans('cruds.mortage.fields.downpayment') }}</label>
                <input step="any" class="form-control {{ $errors->has('downpayment') ? 'is-invalid' : '' }}"
                    type="number" name="downpayment" id="downpayment" value="{{ old('downpayment', '') }}" required>
            </div>
            <div class="form-group">
                <label class="required" for="extra_fee">5 Points</label>
                <input step="any" class="form-control {{ $errors->has('extra_fee') ? 'is-invalid' : '' }}"
                    type="number" name="extra_fee" id="extra_fee" value="{{ old('extra_fee', '') }}" required>
            </div>
            <div class="md-form mb-5">
                <label data-error="wrong" data-success="right" for="form32">Select Bank</label>
                <select name="receiver" class="form-select" aria-label="Default select example">
                    <option value="selected">Select Bank</option>
                    @foreach($banks as $item)
                    <option value="{{$item->id}}">{{$item->Account_title}}({{$item->bank_name}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="required" for="percentage">{{ trans('Interest rate in %') }}</label>
                <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="number"
                    name="percentage" id="percentage" value="{{'1'}}" step="any" required>
                @if($errors->has('percentage'))
                <div class="invalid-feedback">
                    {{ $errors->first('percentage') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.percentage_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="percentage">{{ trans('Balloon period') }}</label>
                <div class="slidecontainer">
                    <input type="range" min="0" max="30" value="0" name="balloon_terms" class="slider"
                        id="ballon_start_date">
                    <div class="term">
                        <p style="margin-left: 8px;" id="ballon_date"></p>
                        <p>years</p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="required" for="percentage">{{ trans('Terms') }}</label>
                <div class="slidecontainer">
                    <input type="range" min="0" max="30" value="0" name="loan_terms" class="slider" id="start_date">
                    <div class="term">
                        <p style="margin-left: 8px;" id="date"></p>
                        <p>years</p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="required" for="property_address">Property Address</label>
                <input class="form-control" type="text" name="property_address" id="property_address"
                    required>
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('Start date') }}</label>
                <input class="form-control" type="date" name="start_date" id="start_date" placeholder="00/00/0000"
                    required>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
<script>
var slider = document.getElementById("start_date");
var output = document.getElementById("date");
output.innerHTML = slider.value;

slider.oninput = function() {
    output.innerHTML = this.value;
}

var slider1 = document.getElementById("ballon_start_date");
var output1 = document.getElementById("ballon_date");
output1.innerHTML = slider1.value;

slider1.oninput = function() {
    output1.innerHTML = this.value;
}
</script>
@endsection