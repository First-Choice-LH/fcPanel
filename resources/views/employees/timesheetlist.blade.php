@extends('layouts.dore.app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-lg-12">
            <h1>Timesheet List</h1>
            <hr/>
        </div>
    </div>
    <div class="white_bg_main">
        <div class="row">
            <div class="col-md-12">
                <h3>{{'There are no jobsites or companies assigned to your account yet.'}}</h3>
            </div>
            
            
            <div class="col-md-4"><a class="btn btnbg btn-primary" href="/employee/jobsites/request">{{ __('REQUEST JOBSITE') }}</a></div>
        </div>
</div>
</div>
</div>
@endsection
@section('script')

@endsection