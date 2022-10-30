@extends('layouts.dore.app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-lg-12">
            <h1>Activities</h1>
            <hr/>
        </div>
    </div>
    <div class="white_bg_main">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center" data-col="message">Activity</th>
                            <th scope="col" class="text-center" data-col="created_at">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $row)
                            <tr>
                                <td class="text-center">{{ getName($row) }} {{ $row->message }}</td>
                                <td class="text-center">{{ $row->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $user->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

