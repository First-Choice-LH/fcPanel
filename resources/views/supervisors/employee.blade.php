@extends('layouts.dore.app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-lg-12">
            <h1>Employee List</h1>
            <hr/>
        </div>
    </div>
    <div class="white_bg_main">
        <div class="row">
                <form metod="get" action="{{ url('employees') }}">
                    <!-- <div class="row">
                        <div class="form-group col-lg-6">
                            <input type="text" class="form-control" name="q" value="{{ \Request::get('q') }}"/>
                        </div>
                        <div class="form-group col-lg-6">
                            <a href="" class="btn btnbg btnbig"> Search </a>
                        </div>
                    </div> -->
                </form>
                <?php $i = 1; ?> 
            <div class="col-lg-12 table-responsive">
                <table class="table table-hover table-bordered sortable_table">
                   <thead class="thead-dark">
                       <tr>
                           <th scope="col" class="text-center" width="10%">#</th>
                           <th scope="col" class="text-center" data-col="first_name">Employee</th>
                           <th scope="col" class="text-center" data-col="phone">Phone</th>
                           <th scope="col" class="d-none d-md-table-cell"></th>
                       </tr>
                   </thead>
                   <tbody>

                       @foreach($rows as $row)
                       <tr>
                       <td scope="row" class="d-none d-md-table-cell"><?php echo $i++;  ?></td>
                           <td scope="row" class="">{{ $row->first_name }} &nbsp {{ $row->last_name }}</td>
                           <td scope="row" class="">{{ $row->phone }}</td>

                           <td class="text-center"><a href="/supervisors/timesheets/{{ $row->id }}/{{ $row->jobsite_id }}" target="_blank" class="btn btnbg btnbig">View Timesheet</a></td>
                       </tr>
                       @endforeach
                   </tbody>
               </table>
                    {{ $rows->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>

@endsection