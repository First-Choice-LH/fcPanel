@extends('layouts.dore.app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-lg-12">
            <h1>Activity</h1>
            <hr>
        </div>
    </div>
    <div class="white_bg_main">
    <div class="main_dashboard_page">
    <div class="row">
        <div class="col-lg-12 table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center" data-col="message">Activity</th>
                            <th scope="col" class="text-center" data-col="created_at">Time</th>
                            <th scope="col" class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <tr>
                            @php ($obj = getActivity($row))
                            <td>{{ $obj['name'].' '.$row->message }}</td>
                            <td>{{ $row->created_at }}</td>
                            <td><a class="btn btnbg" href={{ $obj['url'] }}>VIEW</button></a>
                        </tr>
                        @endforeach                        
                    </tbody>
                </table>
                {{ $rows->links() }}
            </div>
    </div>
    </div>
</div>
</div>
@endsection