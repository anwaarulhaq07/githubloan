@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.mortage.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mortages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.mortage.fields.id') }}
                        </th>
                        <td>
                            {{ $mortage->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('Name') }}
                        </th>
                        <td>
                            {{ $mortage->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('Loan Amount') }}
                        </th>
                        <td>
                            {{ $mortage->loandamoutn }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mortage.fields.downpayment') }}
                        </th>
                        <td>
                            {{ $mortage->downpayment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mortage.fields.percentage') }}
                        </th>
                        <td>
                            {{ $mortage->percentage }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mortage.fields.loan_terms') }}
                        </th>
                        <td>
                            {{ $mortage->loan_terms ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mortage.fields.start_date') }}
                        </th>
                        <td>
                            {{ $mortage->start_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mortages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection