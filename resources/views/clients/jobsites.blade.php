@extends('layouts.dore.app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-lg-12">
            <h1>Client Jobsite List</h1>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover sortable_table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" width="10%">#</th>
                        <th scope="col" class="text-center" data-col="title">Title</th>
                        <th scope="col" class="text-center" data-col="status">Status</th>
                        <th scope="col" class="text-center" width="15%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    <tr>
                        <td class="text-center">{{ $row->id }}</td>
                        <td class="text-center">{{ $row->title }}</td>
                        <td class="text-center">@if($row->status == 1) Active @else Inactive @endif</td>
                        <td class="text-center">
                          <a class="btn btnbg btn-sm btn-info" href="{{ url('/clients/jobsites/employees/'.$row->id) }}">Employees</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  
</script>
@endsection