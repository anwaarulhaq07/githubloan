@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.mortage.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.mortages.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">Customer</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id"
                    id="user_id" required>
                    <option value="selected">Please Select</option>
                    @foreach($users as $id => $entry)
                    <option value="{{ $entry->id }}" {{ old('user_id') == $id ? : '' }}>{{ $entry->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                <div class="invalid-feedback">
                    {{ $errors->first('user') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                @foreach($users as $users)
                <input class="form-control" type="hidden" name="parent_id" id="parent_id" value="{{$users->parent_id}}"
                    required>
                @endforeach
            </div>
            <div class="form-group">
                <label class="required" for="loandamoutn">{{ trans('Loan Amount') }}</label>
                <input step="any" class="form-control {{ $errors->has('loandamoutn') ? 'is-invalid' : '' }}"
                    type="number" name="loandamoutn" id="loandamoutn" value="{{ old('loandamoutn', '') }}" required>
                @if($errors->has('loandamoutn'))
                <div class="invalid-feedback">
                    {{ $errors->first('loandamoutn') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.loandamoutn_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="downpayment">{{ trans('cruds.mortage.fields.downpayment') }}</label>
                <input step="any" class="form-control {{ $errors->has('downpayment') ? 'is-invalid' : '' }}"
                    type="number" name="downpayment" id="downpayment" value="{{ old('downpayment', '') }}" required>
                @if($errors->has('downpayment'))
                <div class="invalid-feedback">
                    {{ $errors->first('downpayment') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.downpayment_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="extra_fee">5 Points</label>
                <input step="any" class="form-control {{ $errors->has('extra_fee') ? 'is-invalid' : '' }}" type="number"
                    name="extra_fee" id="extra_fee" value="{{ old('extra_fee', '') }}" required>
                @if($errors->has('extra_fee'))
                <div class="invalid-feedback">
                    {{ $errors->first('extra_fee') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.downpayment_helper') }}</span>
            </div>
            <div class="md-form mb-5">
                <label data-error="wrong" data-success="right" for="form32">Select Bank</label>
                <select name="receiver" class="form-select" aria-label="Default select example">
                    <option value="selected">Select Bank</option>
                    @foreach($banks as $item)
                    <option value="{{$item->id}}">{{$item->user->name}}({{$item->bank_name}})</option>
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
                <label class="required" for="percentage">{{ trans('Terms') }}</label>
                <div class="slidecontainer">
                    <input type="range" min="1" max="30" value="1" name="loan_terms" class="slider" id="start_date">

                    <div class="term">
                        <p style="margin-left: 8px;" id="date"></p>
                        <p>years</p>
                    </div>
                </div>
            </div>

            <!-- <div class="form-group">
                <label class="required" for="start_date">{{ trans('cruds.mortage.fields.start_date') }}</label>
                
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"  >
                @if($errors->has('start_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.start_date_helper') }}</span>
            </div> -->
            <div class="form-group">
                <label class="required" for="property_address">Property Address</label>
                <input class="form-control" type="text" name="property_address" id="property_address">
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('Start date') }}</label>
                <input class="form-control" type="date" name="start_date" id="start_date">

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
</script>
@endsection