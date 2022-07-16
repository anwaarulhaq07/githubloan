@extends('layouts.master')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            eyee
                        </div>
                    @endif
                    Dear <span class="text-warning font-italic">{{ $user->name }}</span> You are logged in! as <span class="text-primary font-weight-bold">{{ $roles }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection
