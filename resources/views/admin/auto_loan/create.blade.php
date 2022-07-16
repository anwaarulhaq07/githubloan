@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('Add Customer') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{route('admin.loanstore')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('Customer') }}</label>
                <select name="user_id" class="form-select" aria-label="Default select example">
                    @foreach($user as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </select>
            </div>
            <div class="form-group">
                <label class="required" for="loandamoutn">{{ trans('Loan Amount') }}</label>
                <input class="form-control {{ $errors->has('loandamoutn') ? 'is-invalid' : '' }}" type="number" name="amount" id="loandamoutn" value="{{ old('loandamoutn', '') }}" step="1" required>
            </div>
            <div class="form-group">
                <label class="required" for="downpayment">{{ trans('cruds.mortage.fields.downpayment') }}</label>
                <input class="form-control {{ $errors->has('downpayment') ? 'is-invalid' : '' }}" type="number" name="downpayment" id="downpayment" value="{{ old('downpayment', '') }}" step="1" required>
               
            </div>
            <div class="form-group">
                <label class="required" for="percentage">{{ trans('Interest rate') }}</label>
                <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="text" name="percentage" id="percentage" value="{{'1%'}}"  step="1" required>
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
                    <input type="range" min="1" max="20" value="1" name="loan_terms" class="slider" id="start_date">
                    <div class="term">
                        <p style="margin-left: 8px;" id="date"></p>
                        <p>years</p>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('Start date') }}</label>
                <input class="form-control" type="date" name="start_date" id="start_date" placeholder="00/00/0000" required>
               
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

