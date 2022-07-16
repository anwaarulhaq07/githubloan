@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.mortage.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.mortages.update", [$mortage->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="text" name="id" value="{{$mortage->id}}" hidden>

            <div class="form-group">
                <label class="required" for="user_id">{{ trans('Customer') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $mortage->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <label class="required" for="loandamoutn">{{ trans('Loan Amount') }}</label>
                <input class="form-control {{ $errors->has('loandamoutn') ? 'is-invalid' : '' }}" type="number" name="loandamoutn" id="loandamoutn" value="{{ old('loandamoutn', $mortage->loandamoutn) }}" step="1" required>
                @if($errors->has('loandamoutn'))
                    <div class="invalid-feedback">
                        {{ $errors->first('loandamoutn') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.loandamoutn_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="downpayment">{{ trans('cruds.mortage.fields.downpayment') }}</label>
                <input class="form-control {{ $errors->has('downpayment') ? 'is-invalid' : '' }}" type="number" name="downpayment" id="downpayment" value="{{ old('downpayment', $mortage->downpayment) }}" step="1" required>
                @if($errors->has('downpayment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('downpayment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.downpayment_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="percentage">{{ trans('Interest rate') }}</label>
                <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="text" name="percentage" id="percentage" value="{{$mortage->percentage}}" step="1" required>
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
                    <input type="range" min="1" max="20"  name="loan_terms" value="{{$mortage->loan_terms}}" class="slider" id="start_date">

                    <div class="term">
                        <p style="margin-left: 8px;" id="date"></p>
                        <p>years</p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('Start date') }}</label>
                <input class="form-control" type="date" name="start_date" id="start_date" >
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