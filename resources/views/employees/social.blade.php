@extends('layouts.dore.app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-lg-12">
            <h1>Account Information</h1>
            <hr>
        </div>
    </div>
    <div class="main_dashboard_page">
        <div class="row">
            <div class="col-lg-12">
                <div class="card d-flex flex-row mb-4">
                    <div class="d-flex flex-grow-1 min-width-zero">
                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                            <div class="min-width-zero">
                                <p class="list-item-heading mb-1 truncate">You have logged in with {{ $user['social'] }} with the following details applied to your account:</p>

                                @if($user['name'] != '')
                                    <p class="mb-2 text-muted text-small">Name: {{ $user['name'] }}</p>
                                @endif

                                @if($user['email'] != '')
                                    <p class="mb-2 text-muted text-small">Email: {{ $user['email'] }}</p>
                                @endif

                                <div class="bordertop">
                                    <a class="btn btnbg" href="{{ url('/employees/myaccount') }}">My account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection