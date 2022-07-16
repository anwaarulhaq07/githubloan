@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('Add Balance') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.add_balance') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="" value="{{ $bank->id }}">
                <div class="form-group">
                    <label class="required" for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $bank->name }}" readonly>
                </div>
                <div class="form-group">
                    <label class="required" for="bank_name">Bank Name</label>
                    <input type="text" class="form-control" name="bank_name" id="bank_name" value="{{ $bank->bank_name }}"
                        readonly>
                </div>
                <div class="form-group">
                    <label class="required" for="current_balance">{{ trans('Current Balance') }}</label>
                    <input class="form-control" type="number" name="current_balance" id="current_balance"
                        value="{{ $bank->total_balance }}" readonly>
                </div>
                <div class="form-group">
                    <label class="required" for="add_balance">{{ trans('Add Balance') }}</label>
                    <input class="form-control " type="number" name="add_balance" id="add_balance" required>
                </div>
                <div class="form-group">
                    <div style="display: collumn">
                        <div>
                            <label class="required" for="add_balance">{{ trans('Description') }}</label>
                        </div>
                        <div>
                            <textarea class="form-control " name="" id="" cols="30" rows="3" name="description"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
