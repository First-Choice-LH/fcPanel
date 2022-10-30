@extends('layouts.dore.app')

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-lg-12">
            <h1>Employee List</h1>
            <hr/>
        </div>
    </div>
    <?php $i=1; ?>
    <div class="white_bg_main">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-hover sortable_table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center" width="10%">#</th>
                            <th scope="col" class="text-center" data-col="first_name">First Name</th>
                            <th scope="col" class="text-center" data-col="last_name">Last Name</th>
                            <th scope="col" class="text-center" data-col="phone">Phone</th>
                            <th scope="col" class="text-center" width="12%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($employees as $row)
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td class="text-center">{{ $row->first_name }}</td>
                            <td class="text-center">{{ $row->last_name }}</td>
                            <td class="text-center">{{ $row->phone }}</td>
                            <td class="text-center">
                            <a class="btn btnbg" href="{{ url('/employee/jobsites/timesheet/'.$client_id.'/'.$jobsite_id.'/'.$row->id) }}">Timesheet</a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
                {{ $employees->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  
</script>
@endsection