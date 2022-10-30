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
    <div class="col-lg-12">
             <form class="row" method="get" action="">
                <div class="col-lg-3 form-group">       
                    <label class="">Employee</label>             
                    <input class="form-control" type="text" id="employee" value="">
                </div>                         
                <div class="col-lg-1 form-group text-center">
                    <label style="color:transparent;">Action</label> 
                    <button type="button" class="btn btnbg btnbig search">Fetch</button>
                </div>
            </form>
                
    </div>
    <div class="col-lg-6"></div>
  </div>
    <div class="mytable">
  <div class="row">
    <div class="col-lg-12">
            <div class="table-responsive">
                <?php $i = 1  ?>
                <table class="table table-hover table-bordered sortable_table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="d-none d-md-table-cell" width="10%">#</th>
                            <th scope="col" class="" data-col="first_name">Employee</th>
                            <th scope="col" class="" data-col="company_name">Company</th>
                            <th scope="col" class="d-none d-md-table-cell" data-col="title">Jobsite</th>
                            <th scope="col" class="d-none d-md-table-cell">DateStamp</th>
                            <th scope="col" class="d-none d-md-table-cell"></th>
                    </thead>
                    <tbody>
                        @foreach($final as $row)
                        <tr>
                            <td scope="row" class="d-none d-md-table-cell"><?php echo $i++;  ?></td>
                            <td scope="row" class="">{{ $row->first_name }}</td>
                            <td scope="row" class="">{{ $row->company_name }}</td>
                            <td scope="row" class="">{{ $row->title }}</td>
                            <td scope="row" class="">{{ getLastUpdatedTimesheet($row->id) }}</td>
                            <td scope="row" class=""><a href="/timesheets/{{ $row->id }}" target="_blank" class="btn btnbg btnbig">View Timesheet</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                     {{ $final->appends(request()->except('page'))->links() }}
               
            </div>
    </div>
  </div>
</div>
</div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $('.search').click(function(){
        var employee = $('#employee').val();
        var url = "{{ url('/supervisors/timesheets') }}";
        url = url+"?employee="+employee;
        document.location = url;
    });
</script>
@endsection